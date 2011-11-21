/**
 * Transliteration regular expression rules table for Amharic script
 * @author Junaid P V ([[user:Junaidpv]])
 * @date 2011-10-08
 * @credits Referring http://www.lexilogos.com/keyboard/amharic.htm and helps from Sisay
 * License: GPLv3
 */

var rules = [
['\\\\([A-Za-z\\>\\<_~ ])','\\\\','$1'], // include space also

['፼0', '', '፲፼'], // 10000 and 0 becomes 10 10000
['፲፻0', '', '፼'], // 10x100 and 0 becomes 10000
['፻0', '', '፲፻'], // NUM_100 and 0 becomes 10 and 100

['፻0', '', '፲፻'], // 1000

['፳0', '', '፪፻'], // 200
['፴0', '', '፫፻'], // 300
['፵0', '', '፬፻'], // 400
['፶0', '', '፭፻'], // 500
['፷0', '', '፮፻'], // 600
['፸0', '', '፯፻'], // 700
['፹0', '', '፰፻'], // 800
['፺0', '', '፱፻'], // 900

['ጕe', '', 'ጐ'], // gwe
['ጕi', '', 'ጒ'], // gwi
// removed
['ጐe', '', 'ጔ'], // gwee

['ዅe', '', 'ዀ'], // kxwe
['ዅi', '', 'ዂ'], // kxwi
['(ኻ|ኹ|ዅ)a', '', 'ዃ'], // kxwa
['ዀe', '', 'ዄ'], // kxwee

['ኵe', '', 'ኰ'], // kwe
['ኵi', '', 'ኲ'], // kwi
// removed
['ኰe', '', 'ኴ'], // kwee

['ኍe', '', 'ኈ'], // xwe
['ኍi', '', 'ኊ'], // xwi
// removed
['ኈe', '', 'ኌ'], // xwee

['ቝe', '', 'ቘ'], // qhwe
['ቝi', '', 'ቚ'], // qhwi
['ቝa', '', 'ቛ'], // qhwa
['ቘe', '', 'ቜ'], // qhwee

['ቍe', '', 'ቈ'], // qwe
['ቍi', '', 'ቊ'], // qwi
// removed
['ቈe', '', 'ቌ'], // qwee

['ፕe', '', 'ፐ'], // pe
['ፕu', '', 'ፑ'], // pu
['ፕi', '', 'ፒ'], // pi
['ፕa', '', 'ፓ'], // pa
['(ፓ|ፐ|ፒ)e', '', 'ፔ'], // pee
['ፕo', '', 'ፖ'], // po
['(ፓ|ፑ|ፕው)a', '', 'ፗ'], // paa or pua or pwa

['ፍe', '', 'ፈ'], // fe
['ፍu', '', 'ፉ'], // fu
['ፍi', '', 'ፊ'], // fi
['ፍa', '', 'ፋ'], // fa
['(ፋ|ፈ|ፊ)e', '', 'ፌ'], // fee
['ፍo', '', 'ፎ'], // fo
['(ፋ|ፉ|ፍው)a', '', 'ፏ'], // faa or fua or fwa

['ፅe', '', 'ፀ'], // tze
['ፅu', '', 'ፁ'], // tzu
['ፅi', '', 'ፂ'], // tzi
['ፅa', '', 'ፃ'], // tza
['(ፃ|ፀ|ፂ)e', '', 'ፄ'], // tzee
['ፅo', '', 'ፆ'], // tzo
['(ፃ|ፁ|ፅው)a', '', 'ፇ'], // tzaa or tzua or tzwa

['ጽe', '', 'ጸ'], // tse
['ጽu', '', 'ጹ'], // tsu
['ጽi', '', 'ጺ'], // tsi
['ጽa', '', 'ጻ'], // tsa
['(ጻ|ጸ|ጺ)e', '', 'ጼ'], // tsee
['ጽo', '', 'ጾ'], // tso
['(ጻ|ጹ|ጽው)a', '', 'ጿ'], // tsaa or tsua or tswa

['ጵe', '', 'ጰ'], // phe or ppe (ph is alias for pp)
['ጵu', '', 'ጱ'], // phu
['ጵi', '', 'ጲ'], // phi
['ጵa', '', 'ጳ'], // pha
['(ጳ|ጰ|ጲ)e', '', 'ጴ'], // phee
['ጵo', '', 'ጶ'], // pho
['(ጳ|ጱ|ጵው)a', '', 'ጷ'], // phaa or phua or phwa

['ጭe', '', 'ጨ'], // che
['ጭu', '', 'ጩ'], // chu
['ጭi', '', 'ጪ'], // chi
['ጭa', '', 'ጫ'], // cha
['(ጫ|ጨ|ጪ)e', '', 'ጬ'], // chee
['ጭo', '', 'ጮ'], // cho
['(ጫ|ጩ|ጭው)a', '', 'ጯ'], // chaa or chua or chwa

['ጥe', '', 'ጠ'], // the or tte (th is alias for tt)
['ጥu', '', 'ጡ'], // thu
['ጥi', '', 'ጢ'], // thi
['ጥa', '', 'ጣ'], // tha
['(ጣ|ጠ|ጢ)e', '', 'ጤ'], // thee
['ጥo', '', 'ጦ'], // tho
['(ጣ|ጡ|ጥው)a', '', 'ጧ'], // thaa or thua or thwa

['ጝe', '', 'ጘ'], // gge
['ጝu', '', 'ጙ'], // ggu
['ጝi', '', 'ጚ'], // ggi
['ጝa', '', 'ጛ'], // gga
['(ጛ|ጘ|ጚ)e', '', 'ጜ'], // ggee
['ጝo', '', 'ጞ'], // ggo
['(ጛ|ጙ|ጝው)a', '', 'ጟ'], // ggaa or ggua or ggwa

['ግe', '', 'ገ'], // ge
['ግu', '', 'ጉ'], // gu
['ግi', '', 'ጊ'], // gi
['ግa', '', 'ጋ'], // ga
['(ጋ|ገ|ጊ)e', '', 'ጌ'], // gee
['ግo', '', 'ጎ'], // go
['(ጋ|ጉ|ጕ)a', '', 'ጓ'], // gaa or gua or gaa

['ጅe', '', 'ጀ'], // je
['ጅu', '', 'ጁ'], // ju
['ጅi', '', 'ጂ'], // ji
['ጅa', '', 'ጃ'], // ja
['(ጃ|ጀ|ጂ)e', '', 'ጄ'], // jee
['ጅo', '', 'ጆ'], // jo
['(ጃ|ጁ|ጅው)a', '', 'ጇ'], // jaa or jua or jwa

['ዽe', '', 'ዸ'], // dde
['ዽu', '', 'ዹ'], // ddu
['ዽi', '', 'ዺ'], // ddi
['ዽa', '', 'ዻ'], // dda
['(ዻ|ዸ|ዺ)e', '', 'ዼ'], // ddee
['ዽo', '', 'ዾ'], // ddo
['(ዻ|ዹ|ዽው)a', '', 'ዿ'], // ddaa or ddua or ddwa

['ድe', '', 'ደ'], // de
['ድu', '', 'ዱ'], // du
['ድi', '', 'ዲ'], // di
['ድa', '', 'ዳ'], // da
['(ዳ|ደ|ዲ)e', '', 'ዴ'], // dee
['ድo', '', 'ዶ'], // do
['(ዳ|ዱ|ድው)a', '', 'ዷ'], // daa or dua or dwa

['ይe', '', 'የ'], // ye
['ይu', '', 'ዩ'], // yu
['ይi', '', 'ዪ'], // yi
['ይa', '', 'ያ'], // ya
['(ያ|የ|ዪ)e', '', 'ዬ'], // yee
['ይo', '', 'ዮ'], // yo
['(ያ|ዩ|ይው)a', '', 'ዯ'], // yaa or yua or ywa

['ዥe', '', 'ዠ'], // zhe or zze (zh is alias for zz)
['ዥu', '', 'ዡ'], // zhu
['ዥi', '', 'ዢ'], // zhi
['ዥa', '', 'ዣ'], // zha
['(ዣ|ዠ|ዢ)e', '', 'ዤ'], // zhee
['ዥo', '', 'ዦ'], // zho
['(ዣ|ዡ|ዥው)a', '', 'ዧ'], // zhaa or zhua or zhwa

['ዝe', '', 'ዘ'], // ze
['ዝu', '', 'ዙ'], // zu
['ዝi', '', 'ዚ'], // zi
['ዝa', '', 'ዛ'], // za
['(ዛ|ዘ|ዚ)e', '', 'ዜ'], // zee
['ዝo', '', 'ዞ'], // zo
['(ዛ|ዙ|ዝው)a', '', 'ዟ'], // zaa or zua or zwa

['ዕe', '', 'ዐ'], // "e
['ዕu', '', 'ዑ'], // "u
['ዕi', '', 'ዒ'], // "i
['ዕa', '', 'ዓ'], // "a
['(ዓ|ዐ|ዒ)e', '', 'ዔ'], // "ee
['ዕo', '', 'ዖ'], // "o

['ኽe', '', 'ኸ'], // kxe
['ኽu', '', 'ኹ'], // kxu
['ኽi', '', 'ኺ'], // kxi
['ኽa', '', 'ኻ'], // kxa
['(ኻ|ኸ|ኺ)e', '', 'ኼ'], // kxee
['ኽo', '', 'ኾ'], // kxo

['ክe', '', 'ከ'], // ke
['ክu', '', 'ኩ'], // ku
['ክi', '', 'ኪ'], // ki
['ክa', '', 'ካ'], // ka
['(ካ|ከ|ኪ)e', '', 'ኬ'], // kee
['ክo', '', 'ኮ'], // ko
['(ካ|ኩ|ኵ)a', '', 'ኳ'], // kaa or kua or kwa

['እe', "'", 'አ'], // 'e 
['እu', "'", 'ኡ'], // 'u
['እi', "'", 'ኢ'], // 'i
['እa', "'", 'ኣ'], // 'a
['አe', "'", 'ኤ'], // 'ee
['እo', "'", 'ኦ'], // 'o
['(ኣ|ኡ|እው)a', "'[auw]", 'ኧ'], // 'aa or 'ua or 'wa

['ኝe', '', 'ኘ'], // Ne or nne (N is alias for nn)
['ኝu', '', 'ኙ'], // Nu
['ኝi', '', 'ኚ'], // Ni
['ኝa', '', 'ኛ'], // Na
['(ኛ|ኘ|ኚ)e', '', 'ኜ'], // Nee
['ኝo', '', 'ኞ'], // No
['(ኛ|ኙ|ኝው)a', '', 'ኟ'], // Naa or Nua or Nwa

['ንe', '', 'ነ'], // ne
['ንu', '', 'ኑ'], // nu
['ንi', '', 'ኒ'], // ni
['ንa', '', 'ና'], // na
['(ና|ነ|ኒ)e', '', 'ኔ'], // nee
['ንo', '', 'ኖ'], // no
['(ና|ኑ|ንው)a', '', 'ኗ'], // naa or nua or nwa

['ኅe', '', 'ኀ'], // xe
['ኅu', '', 'ኁ'], // xu
['ኅi', '', 'ኂ'], // xi
['ኅa', '', 'ኃ'], // xa
['(ኃ|ኀ|ኂ)e', '', 'ኄ'], // xee
['ኅo', '', 'ኆ'], // xo
['(ኃ|ኁ|ኍ)a', '', 'ኍ'], // xaa or xua or xwa

['ችe', '', 'ቸ'], // ce
['ችu', '', 'ቹ'], // cu
['ችi', '', 'ቺ'], // ci
['ችa', '', 'ቻ'], // ca
['(ቻ|ቸ|ቺ)e', '', 'ቼ'], // cee
['ችo', '', 'ቾ'], // co
['(ቻ|ቹ|ችው)a', '', 'ቿ'], // caa or cua or cwa

['ትe', '', 'ተ'], // te
['ትu', '', 'ቱ'], // tu
['ትi', '', 'ቲ'], // ti
['ትa', '', 'ታ'], // ta
['(ታ|ተ|ቲ)e', '', 'ቴ'], // tee
['ትo', '', 'ቶ'], // to
['(ታ|ቱ|ትው)a', '', 'ቷ'], // taa or tua or twa

['ቭe', '', 'ቨ'], // ve
['ቭu', '', 'ቩ'], // vu
['ቭi', '', 'ቪ'], // vi
['ቭa', '', 'ቫ'], // va
['(ቫ|ቨ|ቪ)e', '', 'ቬ'], // vee
['ቭo', '', 'ቮ'], // vo
['(ቫ|ቩ|ቭው)a', '', 'ቯ'], // vaa or vua or vwa

['ብe', '', 'በ'], // be
['ብu', '', 'ቡ'], // bu
['ብi', '', 'ቢ'], // bi
['ብa', '', 'ባ'], // ba
['(ባ|በ|ቢ)e', '', 'ቤ'], // bee
['ብo', '', 'ቦ'], // bo
['(ባ|ቡ|ብው)a', '', 'ቧ'], // baa or bua or bwa

['ቕe', '', 'ቐ'], // qhe
['ቕu', '', 'ቑ'], // qhu
['ቕi', '', 'ቒ'], // qhi
['ቕa', '', 'ቓ'], // qha
['(ቓ|ቐ|ቒ)e', '', 'ቔ'], // qhee
['ቕo', '', 'ቖ'], // qho

['ቅe', '', 'ቀ'], // qe
['ቅu', '', 'ቁ'], // qu
['ቅi', '', 'ቂ'], // qi
['ቅa', '', 'ቃ'], // qa
['(ቃ|ቀ|ቂ)e', '', 'ቄ'], // qee
['ቅo', '', 'ቆ'], // qo
['(ቃ|ቁ|ቍ)a', '', 'ቋ'], // qaa or qua or qwa

['ሽe', '', 'ሸ'], // she
['ሽu', '', 'ሹ'], // shu
['ሽi', '', 'ሺ'], // shi
['ሽa', '', 'ሻ'], // sha
['(ሻ|ሸ|ሺ)e', '', 'ሼ'], // shae,shee,shie
['ሽo', '', 'ሾ'], // sho
['(ሻ|ሹ|ሽው)a', '', 'ሿ'], // shaa or shua or shwa

['ስe', '', 'ሰ'], // se
['ስu', '', 'ሱ'], // su
['ስi', '', 'ሲ'], // si
['ስa', '', 'ሳ'], // sa
['(ሳ|ሰ|ሲ)e', '', 'ሴ'], // sae,see,sie
['ስo', '', 'ሶ'], // so
['(ሳ|ሱ|ስው)a', '', 'ሷ'], // saa or sua or swa

['ርe', '', 'ረ'], // re
['ርu', '', 'ሩ'], // ru
['ርi', '', 'ሪ'], // ri
['ርa', '', 'ራ'], // ra
['(ራ|ረ|ሪ)e', '', 'ሬ'], // rae,ree,rie
['ርo', '', 'ሮ'], // ro
['(ራ|ሩ|ርው)a', '', 'ሯ'], // raa or rua or rwa

['ሥe', '', 'ሠ'], // sze or sse (sz is alias for ss)
['ሥu', '', 'ሡ'], // szu
['ሥi', '', 'ሢ'], // szi
['ሥa', '', 'ሣ'], // sza
['(ሣ|ሠ|ሢ)e', '', 'ሤ'], // szae,szee,szie
['ሥo', '', 'ሦ'], // szo
['(ሣ|ሡ|ሥው)a', '', 'ሧ'], // szaa or szua or szwa

['ምe', '', 'መ'], // me
['ምu', '', 'ሙ'], // mu
['ምi', '', 'ሚ'], // mi
['ምa', '', 'ማ'], // ma
['(ማ|መ|ሚ)e', '', 'ሜ'], // mae,mee,mie
['ምo', '', 'ሞ'], // mo
['(ማ|ሙ|ምው)a', '', 'ሟ'], // maa or mua or mwa

['ሕe', '', 'ሐ'], // hhe
['ሕu', '', 'ሑ'], // hhu
['ሕi', '', 'ሒ'], // hhi
['ሕa', '', 'ሓ'], // hha
['(ሓ|ሐ|ሒ)e', '', 'ሔ'], // hhae,hhee,hhie
['ሕo', '', 'ሖ'], // hho
['(ሓ|ሑ|ሕው)a', '', 'ሗ'], // hhaa or hhua or hhwa

['ልe', '', 'ለ'], // le
['ልu', '', 'ሉ'], // lu
['ልi', '', 'ሊ'], // li
['ልa', '', 'ላ'], // la
['(ላ|ለ|ሊ)e', '', 'ሌ'], // lae,lee,lie
['ልo', '', 'ሎ'], // lo
['(ላ|ሉ|ልው)a', '', 'ሏ'], // laa or lua or lwa

['ህe', '', 'ሀ'], // he
['ህu', '', 'ሁ'], // hu
['ህi', '', 'ሂ'], // hi
['ህa', '', 'ሃ'], // ha
['(ሃ|ሀ|ሂ)e', '', 'ሄ'], // hae,hee,hie
['ህo', '', 'ሆ'], // ho

['ውe', '', 'ወ'], // we
['ውu', '', 'ዉ'], // wu
['ውi', '', 'ዊ'], // wi
['ውa', '', 'ዋ'], // wa
['(ዋ|ወ|ዊ)e', '', 'ዌ'], // wae,wee,wie
['ውo', '', 'ዎ'], // wo

['አa', '', 'ኣ'], // aa
['(አ|እ|ኢ)e', '', 'ኤ'], // ae or ee or ie
['(እ|አ)h', '', 'ኧ'], // eh or eeh

['ህh', '', 'ሕ'], // hh
['ስ(s|z)', '', 'ሥ'], // ss or sz
['ስh', '', 'ሽ'], // sh
['ቅh', '', 'ቕ'], // qh
['ክx', '', 'ኽ'], // kx
['ዝ(h|z)', '', 'ዥ'], // zh or zz
['ድd', '', 'ዽ'], // dd
['ግg', '', 'ጝ'], // gg
['ት(h|t)', '', 'ጥ'], // th or tt
['ችh', '', 'ጭ'], // ch
['ፕ(h|p)', '', 'ጵ'], // ph or pp
['ትs', '', 'ጽ'], // ts
['ትz', '', 'ፅ'], // tz
['ቅw', '', 'ቍ'], // qw
['ቕw', '', 'ቝ'], // qhw
['ኅw', '', 'ኍ'], // xw
['ክw', '', 'ኵ'], // kw
['ኽw', '', 'ዅ'], // kxw
['ግw', '', 'ጕ'], // gw

['(N|ንn)', '', 'ኝ'], // nn or N

['፩0', '', '፲'], // 10
['፪0', '', '፳'], // 20
['፫0', '', '፴'], // 30
['፬0', '', '፵'], // 40
['፭0', '', '፶'], // 50
['፮0', '', '፷'], // 60
['፯0', '', '፸'], // 70
['፰0', '', '፹'], // 80
['፱0', '', '፺'], // 90
['፲0', '', '፻'], // 100

['h', '', 'ህ'],
['l', '', 'ል'],
['m', '', 'ም'],
['r', '', 'ር'],
['s', '', 'ስ'],
['q', '', 'ቅ'],
['b', '', 'ብ'],
['v', '', 'ቭ'],
['t', '', 'ት'],
['c', '', 'ች'],
['x', '', 'ኅ'],
['n', '', 'ን'],
['k', '', 'ክ'],
['w', '', 'ው'],
['"', '', 'ዕ'],
['z', '', 'ዝ'],
['y', '', 'ይ'],
['d', '', 'ድ'],
['j', '', 'ጅ'],
['g', '', 'ግ'],
['f', '', 'ፍ'],
['p', '', 'ፕ'],

// vowels
['a', '', 'አ'],
["(e|')", '', 'እ'],
['i', '', 'ኢ'],
['o', '', 'ኦ'],
['u', '', 'ኡ'],

['\\;', '', '፥'],
['\\.', '', '።'],
[',', '', '፣'],
['\\:', '', '፤'],
['\\:', '', '፥'],
['/', '', '፨'],
['\\?', '', '፧'],
['[ \\-]', '', '፡'], // space or -
['\\!', '', '፦'],

['1', '', '፩'],
['2', '', '፪'],
['3', '', '፫'],
['4', '', '፬'],
['5', '', '፭'],
['6', '', '፮'],
['7', '', '፯'],
['8', '', '፰'],
['9', '', '፱']
];

jQuery.narayam.addScheme( 'am', {
	'namemsg': 'narayam-am',
	'extended_keyboard': false,
	'lookbackLength': 2,
	'keyBufferLength': 1,
	'rules': rules
} );
