# Oak Island 90 feet stone decryptor

[![Latest Stable Version](https://poser.pugx.org/lucatacconi/oak-island-stone-decryptor/v/stable)](https://packagist.org/packages/lucatacconi/oak-island-stone-decryptor)
[![Total Downloads](https://poser.pugx.org/lucatacconi/oak-island-stone-decryptor/downloads)](https://packagist.org/packages/lucatacconi/oak-island-stone-decryptor)
[![Latest Unstable Version](https://poser.pugx.org/lucatacconi/oak-island-stone-decryptor/v/unstable)](https://packagist.org/packages/lucatacconi/oak-island-stone-decryptor)
[![License](https://poser.pugx.org/lucatacconi/oak-island-stone-decryptor/license)](https://packagist.org/packages/lucatacconi/oak-island-stone-decryptor)


## Oak Island mistery

![Oak Island](https://user-images.githubusercontent.com/9921890/225240434-ab2da47a-e858-43d1-8742-242f97bbcf93.jpg)

For those who don't know anything about **Oak Island**, legend tell us that a deep well was dug on the island and that a great treasure was buried there. The story of the well has its roots in stories that trace the first excavation attempts back to 1795, when the young **Daniel McGinnis** (1777-1862), while walking, was intrigued by a depression in the ground located near an old oak tree, among the branches of which a hoist stood out, a sort of pulley also used on ships.

The next day Daniel, in the company of two friends familiar with ancient local legends about pirates and hidden treasures, began the excavations. But they soon realized that that depression hid a very particular well. Going deeper, every three meters they found a platform of oak wood planks but, having reached the third layer, they were forced to abandon the enterprise, which was too difficult for them. Thus was born the legend of Oak Island. That well took the name of Money Pit, the well of money.


In 1802, a private company, the **Onslow Company**, giving credence to the story of Daniel McGinnis and his companions, resumed excavations. Some layers of charcoal and clay were found but, above all, coconut fibers, which were certainly not local, because the coconut palm does not grow in Canada.

At 90 feet down the morale of the men skyrocketed. They found themselves in front of a huge stone slab that bore indecipherable engravings, the one that will later be renamed the **90 feet inscribed stone**. It was already night when, probing the ground below with one foot, they felt something resistant. It is said that it was a possible treasure chest, or another slab.

The exhausted workers decided to postpone the discovery until the next day, but a nasty surprise awaited them. During the night the water from the Atlantic had completely flooded the well, and attempts to empty it were in vain: the water level remained constant. It was as if, in order to empty the well, the whole ocean had to be emptied. In fact, there is said to be a conduit of pipes starting under Smith's Cove; when the tide rises the conduit carries water into the Money Pit.

Over the years, about another hundred attempts have been made, which still continue today, also becoming a TV series, where the **Lagina brothers** try to dispel the veil of mystery that hides the island's secrets. However, there is still no trace of the treasure.

<br />

## The 90 feet inscribed stone

But let's go back a step and go back to the 90-foot stone: legend says the stone featured a series of engraved symbols, broken up into distinct elements that look like words.
There is also what should be the reproduction of the table and the arrangement of the symbols.

![Oak Island 90 feet inscribed stone](https://user-images.githubusercontent.com/9921890/225243481-ab78abc2-4c37-44d8-a056-9d291efcac6e.png)

This is where our game begins. Our attempt is to use, for fun, PHP and other latest generation languages ​​(Lua and maybe even Dart) to try an automatic interpretation of the stone.

Here are the assumptions we worked on:
* some of the symbols are repeated within several elements that we can consider words: this means that, by crossing the letters corresponding to the repeated symbols, we can build a set of possible sentences that correspond to the scheme of the symbols.
* the engraved rock should be dated between 1400 and 1600. We therefore consider English, French, Spanish and Latin as possible languages.
* some words begin with a repeating symbol. We can try to imagine that the symbol repeated at the beginning of what could be a sentence are numbers.
* the code may contain obsolete words that are currently no longer in dictionaries. This could affect the text parsing.


A big thank you to the following Github and non-Github repositories from which we got the word list of the languages ​​we chose for the project:

* [Github Dwyl/english-words](https://github.com/dwyl/english-words/)
* [Github Bbloomf/verbalatina](https://github.com/bbloomf/verbalatina/)
* [Nurykabe.com ](http://www.nurykabe.com/dump/text/lists/)
* [Pallier.org - liste-de-mots-francais](https://www.pallier.org/liste-de-mots-francais.html)
* [Github Lorenbrichter/Words](https://github.com/lorenbrichter/Words/)

> :warning: **This study has no scientific value and I have no presumption of being anything other than entertainment.**

<br />

## Dictionary attack mode

Below are the different methods of launching the analysis on the text of the stone:

### Method 1 - M1

![Method 1 - M1](https://user-images.githubusercontent.com/9921890/225400911-0d5fc254-f8d5-4a4a-a19b-bd58e4546607.png)

Here are the assumptions we worked on in Method 1:

* at the beginning of word 8 there are two symbols in the shape of a cross (Symb_08). In the languages ​​considered, there are no words that begin with the same repeated letter. So let's try to consider them as numbers and assign them a random numeric value.
* by resemblance I also consider the first symbol of the word 5 as a number (Symb_13). We assign it a random numeric value.
* we consider the third symbol of the word 6 as a plus-shaped symbol and not as a cross-shaped symbol, therefore with content other than Symb_08
* we consider word 2 composed of 4 symbols, two of which are repeated at position 2 and 3 (both Symb_09)

Here's how the word parsing goes:
Word2 → Word4 → Word7 → Word1 → Word3 → Word5 → Word8 → Word6

> :warning:**More cryptogram analysis algorithms will be added soon**

<br />

## System Requirements

* PHP 7.4 or newer if you want to use the PHP version + php-mbstring module
* Lua 5.3 or newer if you want to use the Lua version
* Dart 2.12 or newer if you want to use the Dart version
* Apache or Nginx server if you want to use application by web browser
* Composer if you want to install the application by Composer

<br />

## Application installation

To install the application you can download the Github repository or use [Composer](https://getcomposer.org/) with the following instruction:
```
composer create-project lucatacconi/oak-island-stone-decryptor
```

If you want to use the application via web browser, you also need to install an Http server. Since the execution of the batch could take many minutes it will be necessary to configure the max execution time of php to a high value.
```
max_execution_time = 100000
```

<br />


## Usage

Below is the list of available launch modes:

With PHP it is possible to launch the application in batch mode or from the browser.

### PHP usage by shell

In batch mode you can launch the application as follows:
```
php ./decryptor_v01.php --language=FR --mode=M1
```
**language** parameter can be **EN** to load the English dictionary, **FR** to load the French dictionary, **ES** to load the Spanish dictionary and **LAT** to load the Latin dictionary.

**MODE** parameter represents the algorithm with which the cryptogram is analyzed.

The outcome of the upload will be entered in ./results/outcome.log in JSON format

<br />

### PHP usage by browser

To launch the application from the browser, enter the following address in the browser:
```
http://SERVER_HOST/oak-island-stone-decryptor/decryptor_v01.php?LANGUAGE=FR&MODE=M1[[&LOG_FILE=Y]]
```
**SERVER_HOST** is the address of the server where the application is installed or the localhost address if you are using a local server.

**LANGUAGE** parameter can be **EN** to load the English dictionary, **FR** to load the French dictionary, **ES** to load the Spanish dictionary and **LAT** to load the Latin dictionary.

**MODE** parameter represents the algorithm with which the cryptogram is analyzed.

**LOG_FILE** parameter is optional and can be **Y** to save the outcome also in ./results/outcome.log in JSON format as well as displayed on the browser always in JSON format; **N** to not save the outcome in log file and display only on the browser in JSON format.

<br />

### LUA usage

Cooming soon

<br />

## Contributing

The project was born as a game and to practice learning Dart and Lua. I would also like it to become a starting point for sharing ideas and discussing with other developers or interested parties.
Anyone interested can write me here [Luca Tacconi](mailto:luca.tacconi@monolite.net) or open an issue on the repository.
Contributions are extremely welcome :heart:.


## Credits

* [Luca Tacconi](https://github.com/lucatacconi)


## License

**Oak Island 90 feet stone decryptor** is licensed under the MIT license. See [License File](LICENSE.md) for more information.
