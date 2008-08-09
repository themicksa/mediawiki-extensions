/*
 * Copyright (c) 2008 Andrew Garrett.
 * Copyright (c) 2008 River Tarnell <river@wikimedia.org>
 * Derived from public domain code contributed by Victor Vasiliev.
 *
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or
 * implied warranty.
 */

#ifndef DATUM_VISITORS_H
#define DATUM_VISITORS_H

#include	"datum/create.h"

namespace afp {
namespace datum_impl {

/* Given T and U, find the preferred type for maths (i.e. double, if present) */
template<typename T, typename U>
struct preferred_type {
	typedef T type;
};

template<typename T>
struct preferred_type<double, T> {
	typedef double type;
};

template<typename T>
struct preferred_type<T, double> {
	typedef double type;
};

template<>
struct preferred_type<double, double> {
	typedef double type;
};


/*
 * Convert a string to an integer value.
 */
template<typename charT, typename T>
struct from_string_converter {
	typedef T type;

	static type convert(T const &v) {
		return v;
	}
};

template<typename charT>
struct from_string_converter<charT, std::basic_string<charT> > {
	typedef long int type;

	template<typename T>
	static type convert(T const &v) {
		try {
			return boost::lexical_cast<type>(v);
		} catch (boost::bad_lexical_cast &e) {
			return 0;
		}
	}
};

/*
 * Conversions from datum to other types.
 */
template<typename charT>
struct to_string_visitor : boost::static_visitor<std::basic_string<charT> > {
	std::basic_string<charT> operator() (std::basic_string<charT> const &v) const {
		return v;
	}

	template<typename T>
	std::basic_string<charT> operator() (T const &v) const {
		return boost::lexical_cast<std::basic_string<charT> >(v);
	}
};

template<typename charT>
struct to_int_visitor : boost::static_visitor<long int> {
	long int operator() (std::basic_string<charT> const &v) const {
		try {
			return boost::lexical_cast<long int>(v);
		} catch (boost::bad_lexical_cast &e) {
			return 0;
		}
	}

	long int operator() (double o) const {
		return (long int) o;
	}

	template<typename T>
	long int operator() (T const &v) const {
		return v;
	}
};

template<typename charT>
struct to_double_visitor : boost::static_visitor<double> {
	double operator() (std::basic_string<charT> const &v) const {
		try {
			return boost::lexical_cast<double>(v);
		} catch (boost::bad_lexical_cast &e) {
			return 0;
		}
	}

	template<typename T>
	double operator() (T const &v) const {
		return v;
	}
};

/*
 * A visitor that performs an arithmetic operation on its arguments,
 * after doing appropriate int->double promotion.
 */
template<typename charT, template<typename V> class Operator>
struct arith_visitor : boost::static_visitor<basic_datum<charT> > {
	/*
	 * Anything involving a double returns a double.
	 * Otherwise, int is returned.
	 */
	template<typename T, typename U>
	basic_datum<charT> operator() (T const &a, U const &b) const {
		typedef typename from_string_converter<charT, T>::type a_type;
		typedef typename from_string_converter<charT, U>::type b_type;
		typedef typename preferred_type<a_type, b_type>::type preferred_type;

		Operator<preferred_type> op;
		return create_datum<charT, preferred_type>::create(op(
			from_string_converter<charT, T>::convert(a), 
			from_string_converter<charT, U>::convert(b)));
	}

	/*
	 * Unary version.
	 */
	template<typename T>
	basic_datum<charT> operator() (T const &a) const {
		typedef typename from_string_converter<charT, T>::type a_type;
		typedef typename preferred_type<a_type, a_type>::type preferred_type;

		Operator<preferred_type> op;
		return create_datum<charT, preferred_type>::create(
				op(from_string_converter<charT, T>::convert(a)));
	}

};

/*
 * Like arith_visitor, but for equality comparisons.
 */
template<
	typename charT,
	template<typename V> class Operator,
	typename T,
	typename U>
struct compare_visitor_impl {
	bool operator() (T const &a, U const &b) const {
		typedef typename from_string_converter<charT, T>::type a_type;
		typedef typename from_string_converter<charT, U>::type b_type;
		typedef typename preferred_type<a_type, b_type>::type preferred_type;

		Operator<preferred_type> op;
		return op(
			from_string_converter<charT, T>::convert(a), 
			from_string_converter<charT, U>::convert(b));
	}
};

/*
 * Specialise for string<>string comparisons
 */
template<typename charT, template<typename V> class Operator>
struct compare_visitor_impl<
		charT, 
		Operator, 
		std::basic_string<charT>, 
		std::basic_string<charT> 
	> : boost::static_visitor<bool> {

	bool operator() (std::basic_string<charT> const &a, std::basic_string<charT> const &b) const {
		Operator<std::basic_string<charT> > op;
		return op(a, b);
	}
};

template<typename charT, template<typename V> class Operator>
struct compare_visitor : boost::static_visitor<bool> {
	template<typename T, typename U> 
	bool operator() (T const &a, U const &b) const {
		return compare_visitor_impl<charT, Operator, T, U>()(a, b);
	}
};

/*
 * For comparisons that only work on integers - strings will be converted.
 */
template<typename charT, template<typename V> class Operator>
struct arith_compare_visitor : boost::static_visitor<bool> {
	template<typename T, typename U>
	bool operator() (T const &a, U const &b) const {
		typedef typename from_string_converter<charT, T>::type a_type;
		typedef typename from_string_converter<charT, U>::type b_type;
		typedef typename preferred_type<a_type, b_type>::type preferred_type;

		Operator<preferred_type> op;
		return op(
			from_string_converter<charT, T>::convert(a), 
			from_string_converter<charT, U>::convert(b));
	}
};

} // namespace datum_impl
} // namespace afp

#endif	/* !DATUM_VISITORS_H */
