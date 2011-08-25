/**
 * Parser tree structure for WikiScripts parser. This tree is intended to be easy
 * to construct bottom-up (due to LR parsing), optimize and traverse top-down
 * (due to how interpreter works).
 * 
 * Note that the data format is supposed to be platform-independent, so specific 
 * integer length is used.
 */

#ifndef _WS_TREE_H
#define _WS_TREE_H

#include <stdint.h>
#include <stdbool.h>
#include <limits.h>

#define WS_TREE_SIZE_INIT 40
#define WS_TREE_SIZE_STEP 10

#define WS_NODE_ID_INVALID UINT_MAX

typedef uint32_t ws_parser_node_id;

typedef struct {
	/* Terminal or non-terminal */
	uint8_t type;

	/* ID of the (non-)terminal */
	uint8_t value;
} ws_parser_node;


typedef struct {
	ws_parser_node_id parent;
	ws_parser_node_id child;
	uint8_t number;
} ws_parser_node_link;

/**
 * The tree has three parts:
 * * Nodes, which are terminals (with type) and non-terminals in the tree.
 * * Links between nodes (parent->child)
 * * Symbols, i.e. the values of tokens. For example, if the token is string, the
 *     value of the string would be there.
 * 
 * At the beginning, the node ID of each node is an index in node array, the
 * links[i] is a parent-child link for a child node with index i, and symbols[i]
 * is a reference to the symbol for nodes[i] or NULL if that's not applicable.
 * 
 * However, since we are going to traverse tree top-down, we will need to search quickly
 * by parent. Hence, once we finish building the tree, we will finalize it. Finalization includes:
 * * Breaking long one-item production chain (exprA -> exprB, exprB -> exprC, ...)
 * * Removing orphan nodes
 * * Reallocating space to minimum
 * * Sorting link nodes by key (parent, child number)
 * 
 * After that we can freely apply binary search to find children of a given node and serialize the
 * tree.
 */
typedef struct {
	int count;
	int allocated;
	ws_parser_node* nodes;

	// When forming tree, number of allocated links = number of nodes.
	// After finalizing, it is number of nodes - 1, since root node has no parent.
	ws_parser_node_link* links;

	ws_parser_node_id root;

	bool finalized;

	// Number of allocated and present symbols is mapped to the number of the nodes
	char** symbols;

	// Temporary array used to store a flag about certain node having single child
	bool* singleprods;
} ws_parser_tree;

/**
 * Results of the children search by node.
 */
typedef struct {
	int count;
	ws_parser_node_link* links;
} ws_parser_tree_children;

/**
 * Initializes the parser tree.
 * 
 * Returns NULL if out of memory.
 */
ws_parser_tree* ws_parser_tree_init();

/**
 * Adds an orphan node into the tree. Returns node ID or WS_NODE_ID_INVALID.
 * 
 * Symbol may be either value of the terminal or NULL.
 */
ws_parser_node_id ws_parser_tree_add(ws_parser_tree* tree, ws_parser_node node, char* symbol);

/**
 * Adds node child as nth child of parent.
 */
bool ws_parser_tree_link(ws_parser_tree* tree, ws_parser_node_id parent, ws_parser_node_id child, uint8_t number);

/**
 * Sets the root of the tree.
 */
void ws_parser_tree_set_root(ws_parser_tree* tree, ws_parser_node_id root);

/**
 * Cleanup and validation of the tree.
 */
bool ws_parser_tree_finalize(ws_parser_tree* tree);

/**
 *  Searches all the children of a given node and returns the result.
 */
ws_parser_tree_children ws_parser_tree_search_children(ws_parser_tree* tree, ws_parser_node_id node);

/**
 * Free the resources allocated for the tree.
 */
void ws_parser_tree_free(ws_parser_tree* tree);

#endif /* _WS_TREE_H */
