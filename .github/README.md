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

* ![ Github Dwyl/english-words ](https://github.com/dwyl/english-words)
* ![ Github Bbloomf/verbalatina ](https://github.com/bbloomf/verbalatina)
* ![ Nurykabe.com ](http://www.nurykabe.com/dump/text/lists/)
* ![ Pallier.org - liste-de-mots-francais ](https://www.pallier.org/liste-de-mots-francais.html)
* ![ Github Lorenbrichter/Words ](https://github.com/lorenbrichter/Words)

> :warning: **This study has no scientific value and I have no presumption of being anything other than entertainment.**

## System Requirements

* PHP 7.4 or newer
* Lua 5.3 or newer
* Dart 2.12 or newer
* Composer



### Composer setup

It's recommended that you use [Composer](https://getcomposer.org/) to install Oak Island 90 feet stone decryptor.

Starting from your **Apache Server**'s **Document Root** folder or from a directory served by a virtual host, begin the application setup by Composer command:
```
composer create-project lucatacconi/oak-island-stone-decryptor
```
This will install the stone decryptor and all required dependencies.



### Usage

http://localhost/oak-island-stone-decryptor/decryptor_v01.php?LANGUAGE=FR&MODE=M1

## Contributing

The project was born as a game and to practice learning Dart and Lua. I would also like it to become a starting point for sharing ideas and discussing with other developers or interested parties.
Anyone interested can write me here [Luca Tacconi](luca.tacconi@monolite.net) or open an issue on the repository.
Contributions are extremely welcome :heart:.

## Credits

* [Luca Tacconi](https://github.com/lucatacconi)

## License

**Oak Island 90 feet stone decryptor** is licensed under the MIT license. See [License File](LICENSE.md) for more information.
