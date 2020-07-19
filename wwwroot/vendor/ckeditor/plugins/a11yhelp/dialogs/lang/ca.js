﻿/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.plugins.setLang( 'a11yhelp', 'ca', {
	title: 'Instruccions d\'Accessibilitat',
	contents: 'Continguts de l\'Ajuda. Per tancar aquest quadre de diàleg premi ESC.',
	legend: [
		{
		name: 'General',
		items: [
			{
			name: 'SuperAdmin de barra d\'eines',
			legend: 'Premi ${toolbarFocus} per desplaçar-se per la barra d\'eines. Vagi en el següent i anterior grup de barra d\'eines amb TAB i SHIFT+TAB. Vagi en el següent i anterior botó de la barra d\'eines amb RIGHT ARROW i LEFT ARROW. Premi SPACE o ENTER per activar el botó de la barra d\'eines.'
		},

			{
			name: 'SuperAdmin de quadre de diàleg',
			legend:
				'Dins d\'un quadre de diàleg, premi la tecla TAB per desplaçar-se fins al següent element del quadre de diàleg, premi la tecla Shift + TAB per desplaçar-se a l\'anterior element del quadre de diàleg, premi la tecla ENTER per confirmar el quadre de diàleg, premi la tecla ESC per cancel·lar el quadre de diàleg. Quan un quadre de diàleg té diverses pestanyes, la llista de pestanyes pot ser assolit ja sigui amb ALT + F10 o TAB, com a part de l\'ordre de tabulació del quadre de diàleg. Amb la llista de pestanyes seleccionada, pot anar a la fitxa següent i anterior amb la tecla FLETXA DRETA i ESQUERRA, respectivament.'
		},

			{
			name: 'SuperAdmin de menú contextual',
			legend: 'Premi ${contextMenu} o APPLICATION KEY per obrir el menú contextual. Després desplacis a la següent opció del menú amb TAB o DOWN ARROW. Desplacis a l\'anterior opció amb SHIFT+TAB o UP ARROW. Premi SPACE o ENTER per seleccionar l\'opció del menú. Obri el submenú de l\'actual opció utilitzant SPACE o ENTER o RIGHT ARROW. Pot tornar a l\'opció del menú pare amb ESC o LEFT ARROW. Tanqui el menú contextual amb ESC.'
		},

			{
			name: 'SuperAdmin de caixa de llista',
			legend: 'Dins d\'un quadre de llista, desplacis al següent element de la llista amb TAB o DOWN ARROW. Desplacis a l\'anterior element de la llista amb SHIFT+TAB o UP ARROW. Premi SPACE o ENTER per seleccionar l\'opció de la llista. Premi ESC per tancar el quadre de llista.'
		},

			{
			name: 'SuperAdmin de barra de ruta de l\'element',
			legend: 'Premi ${elementsPathFocus} per anar als elements de la barra de ruta. Desplacis al botó de l\'element següent amb TAB o RIGHT ARROW. Desplacis a l\'anterior botó amb SHIFT+TAB o LEFT ARROW. Premi SPACE o ENTER per seleccionar l\'element a l\'editor.'
		}
		]
	},
		{
		name: 'Ordres',
		items: [
			{
			name: 'Desfer ordre',
			legend: 'Premi ${undo}'
		},
			{
			name: 'Refer ordre',
			legend: 'Premi ${redo}'
		},
			{
			name: 'Ordre negreta',
			legend: 'Premi ${bold}'
		},
			{
			name: 'Ordre cursiva',
			legend: 'Premi ${italic}'
		},
			{
			name: 'Ordre subratllat',
			legend: 'Premi ${underline}'
		},
			{
			name: 'Ordre enllaç',
			legend: 'Premi ${link}'
		},
			{
			name: 'Ordre amagar barra d\'eines',
			legend: 'Premi ${toolbarCollapse}'
		},
			{
			name: 'Ordre per accedir a l\'anterior espai enfocat',
			legend: 'Premi ${accessPreviousSpace} per accedir a l\'enfocament d\'espai més proper inabastable abans del símbol d\'intercalació, per exemple: dos elements HR adjacents. Repetiu la combinació de tecles per arribar a enfocaments d\'espais distants.'
		},
			{
			name: 'Ordre per accedir al següent espai enfocat',
			legend: 'Premi ${accessNextSpace} per accedir a l\'enfocament d\'espai més proper inabastable després del símbol d\'intercalació, per exemple: dos elements HR adjacents. Repetiu la combinació de tecles per arribar a enfocaments d\'espais distants.'
		},
			{
			name: 'Ajuda d\'accessibilitat',
			legend: 'Premi ${a11yHelp}'
		},
			{
			name: ' Paste as plain text', // MISSING
			legend: 'Press ${pastetext}', // MISSING
			legendEdge: 'Press ${pastetext}, followed by ${paste}' // MISSING
		}
		]
	}
	],
	tab: 'Tabulació',
	pause: 'Pausa',
	capslock: 'Bloqueig de majúscules',
	escape: 'Escape',
	pageUp: 'Pàgina Amunt',
	pageDown: 'Pàgina Avall',
	leftArrow: 'Fletxa Esquerra',
	upArrow: 'Fletxa Amunt',
	rightArrow: 'Fletxa Dreta',
	downArrow: 'Fletxa Avall',
	insert: 'Inserir',
	leftWindowKey: 'Tecla Windows Esquerra',
	rightWindowKey: 'Tecla Windows Dreta',
	selectKey: 'Tecla Seleccionar',
	numpad0: 'Teclat Numèric 0',
	numpad1: 'Teclat Numèric 1',
	numpad2: 'Teclat Numèric 2',
	numpad3: 'Teclat Numèric 3',
	numpad4: 'Teclat Numèric 4',
	numpad5: 'Teclat Numèric 5',
	numpad6: 'Teclat Numèric 6',
	numpad7: 'Teclat Numèric 7',
	numpad8: 'Teclat Numèric 8',
	numpad9: 'Teclat Numèric 9',
	multiply: 'Multiplicació',
	add: 'Suma',
	subtract: 'Resta',
	decimalPoint: 'Punt Decimal',
	divide: 'Divisió',
	f1: 'F1',
	f2: 'F2',
	f3: 'F3',
	f4: 'F4',
	f5: 'F5',
	f6: 'F6',
	f7: 'F7',
	f8: 'F8',
	f9: 'F9',
	f10: 'F10',
	f11: 'F11',
	f12: 'F12',
	numLock: 'Bloqueig Teclat Numèric',
	scrollLock: 'Bloqueig de Desplaçament',
	semiColon: 'Punt i Coma',
	equalSign: 'Símbol Igual',
	comma: 'Coma',
	dash: 'Guió',
	period: 'Punt',
	forwardSlash: 'Barra Diagonal',
	graveAccent: 'Accent Obert',
	openBracket: 'Claudàtor Obert',
	backSlash: 'Barra Invertida',
	closeBracket: 'Claudàtor Tancat',
	singleQuote: 'Cometa Simple'
} );
