<?php

		$servername = "";
		$databasename = "";
		$username = "";
		$password = "";


        require_once("DatabaseQueryObject.php");


		
		// Search format: Genesis 1-4
		// Contains space and "-"
		$bookChapterFromToQuery = "SELECT Book, Chapter, Verse, Word FROM `English` WHERE Book = ? AND Chapter BETWEEN ? and ?";

		// Search format: Genesis 4:1-4
		// Contains space and ":", and "-"
		$bookChapterVerseFromVerseToQuery = "SELECT Book, Chapter, Verse, Word FROM `English` WHERE `Book` = ? AND `Chapter` = ? AND `Verse` BETWEEN ? AND ?";

		// Search format: Genesis 4:1
		// Contains space and ":".
		$bookChapterVerseQuery = "SELECT Book, Chapter, Verse, Word FROM `English` WHERE `Book` = ? AND `Chapter` = ? AND `Verse` = ?";

		// Search format: Genesis 1
		// Contains space, and not :, or -.
		$bookChapterQuery = "SELECT Book, Chapter, Verse, Word FROM `English` WHERE Book = ? AND Chapter = ?";

		// Search format: Genesis
		// May contain space at the beginning.
		$bookQuery = "SELECT Book, Chapter, Verse, Word FROM `English` WHERE Book = ?";

		// Basic keyword query.
		$keywordQuery = "SELECT Book, Chapter, Verse, Word FROM `English` WHERE Word LIKE ?";
		
		
		$chapterCountQuery = "SELECT COUNT(DISTINCT Chapter) FROM `English` WHERE Book = ?";
		
		
		// Array accessibility:
		/*
            acceptableQueries[0] = "identifier name"
            acceptableQueries[1] = "regex data"
            acceptableQueries[2] = Start Position of preg_split() data. [song of solomon requires extra care]
            acceptableQueries[3] = End Position of preg_split() data.

        */

		// Note that "Song of Solomon" could be a capture group on it's own; there would be no need to split it word-by-word. Will probably add later since I already coded it in.
		// Song of Solomon Regexes
		$regexSolomonChapterVerse = "/^(\w{4})\s(\w{2})\s(\w{7})\s(\d{1,3}):(\d{1,3})$/";
		$regexSolomonChapterVerseFromVerseTo = "/^(\w{4})\s(\w{2})\s(\w{7})\s(\d{1,3}):(\d{1,3})-(\d{1,3})$/";
		$regexSolomonChapterFromChapterTo = "/^(\w{4})\s(\w{2})\s(\w{7})\s(\d{1,3})-(\d{1,3})$/";
		$regexSolomonChapter = "/^(\w{4})\s(\w{2})\s(\w{7})\s(\d{1,3})$/";
		$regexSolomon = "/^(\w{4})\s(\w{2})\s(\w{7})$/";

		// Multiple-book Regexes.
		$regexNumBookBookChapterVerse = "/^(\d{1})\s(\w{1,13})\s(\d{1,3}):(\d{1,3})$/";
		$regexNumBookBookChapterVerseFromVerseTo = "/^(\d{1})\s(\w{1,13})\s(\d{1,3}):(\d{1,3})-(\d{1,3})$/";
		$regexNumBookBookChapterFromChapterTo = "/^(\d{1})\s(\w{1,13})\s(\d{1,3})-(\d{1,3})$/";
		$regexNumBookBookChapter = "/^(\d{1})\s(\w{1,13})\s(\d{1,3})$/";
		$regexNumBook = "/^(\d)\s(\w{1,13})$/";

		// Standard, non-multiple-book Regexes.
		$regexBookChapterVerse = "/^(\w{1,13})\s(\d{1,3}):(\d{1,3})$/";
		$regexBookChapterVerseFromVerseTo = "/^(\w{1,13})\s(\d{1,3}):(\d{1,3})-(\d{1,3})$/";
		$regexBookChapterFromChapterTo = "/^(\w{1,13})\s(\d{1,3})-(\d{1,3})$/";
		$regexBookChapter = "/^(\w{1,13})\s(\d{1,3})$/";
		$regexBook = "/^(\w{1,13})$/";

		// Chinese / Traditional Chinese Keyword query
		$regexKeyword = "/^(\w{3,15})$/";
		
		// Chinese / Traditional Chinese Standard query
		$regexChineseBookChapterVerse = "/^(\p{Han}*)\s(\d{1,3})(：{1}|:{1})(\d{1,3})$/u";
		$regexChineseBookChapterVerseFromVerseTo = "/^(\p{Han}*)\s(\d{1,3})(：{1}|:{1})(\d{1,3})(-{1}|-{1}|—{1,2})(\d{1,3})$/u";
		$regexChineseBookChapterFromChapterTo = "/^(\p{Han}*)\s(\d{1,3})(-{1}|-{1}|—{1,2})(\d{1,3})$/u";
		$regexChineseBookChapter = "/^(\p{Han}*)\s(\d{1,3})$/u";
		$regexChineseBook = "/^(\p{Han}*)$/u";

		
		
		
		


		$dqo = array();
		// Song of Solomon
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexSolomonChapterVerse, 0, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexSolomonChapterVerseFromVerseTo, 1, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexSolomonChapterFromChapterTo, 2, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexSolomonChapter, 3, "English"));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexSolomon, 4, "English"));

		// Multiple book names. Example: 2 Peter
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexNumBookBookChapterVerse, 0, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexNumBookBookChapterVerseFromVerseTo, 1, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexNumBookBookChapterFromChapterTo, 2, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexNumBookBookChapter, 3, "English"));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexNumBook, 4, "English"));

		// Single book names. Example: Genesis
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexBookChapterVerse, 0, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexBookChapterVerseFromVerseTo, 1, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexBookChapterFromChapterTo, 2, "English"));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexBookChapter, 3, "English"));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexBook, 4, "English"));

		// English Keyword search
		array_push($dqo, new DatabaseQueryObject($keywordQuery, array(), "s", $regexKeyword, 5, "English"));
		
		
		// Chinese book search
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexChineseBookChapterVerse, 0, "ChineseSimplified"));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexChineseBookChapterVerseFromVerseTo, 1, "ChineseSimplified"));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexChineseBookChapterFromChapterTo, 2, "ChineseSimplified"));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexChineseBookChapter, 3, "ChineseSimplified"));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexChineseBook, 4, "ChineseSimplified"));

		/*
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexChineseBookChapterVerse, 0, "ChineseTraditional"));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexChineseBookChapterVerseFromVerseTo, 1, "ChineseTraditional"));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexChineseBookChapterFromChapterTo, 2, "ChineseTraditional"));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexChineseBookChapter, 3, "ChineseTraditional"));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexChineseBook, 4, "ChineseTraditional"));*/


?>