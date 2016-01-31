<?php

		$servername = "";
		$databasename = "";
		$username = "";
		$password = "";



        require_once("DatabaseQueryObject.php");


		// Search format: Genesis 1-4
		// Contains space and "-"
		$bookChapterFromToQuery = "SELECT Book, Chapter, Verse, Word FROM `Contents` WHERE Book = ? AND Chapter BETWEEN ? and ?";

		// Search format: Genesis 4:1-4
		// Contains space and ":", and "-"
		$bookChapterVerseFromVerseToQuery = "SELECT Book, Chapter, Verse, Word FROM `Contents` WHERE `Book` = ? AND `Chapter` = ? AND `Verse` BETWEEN ? AND ?";

		// Search format: Genesis 4:1
		// Contains space and ":".
		$bookChapterVerseQuery = "SELECT Book, Chapter, Verse, Word FROM `Contents` WHERE `Book` = ? AND `Chapter` = ? AND `Verse` = ?";

		// Search format: Genesis 1
		// Contains space, and not :, or -.
		$bookChapterQuery = "SELECT Book, Chapter, Verse, Word FROM `Contents` WHERE Book = ? AND Chapter = ?";

		// Search format: Genesis
		// May contain space at the beginning.
		$bookQuery = "SELECT Book, Chapter, Verse, Word FROM `Contents` WHERE Book = ?";

		// Basic keyword query.
		$keywordQuery = "SELECT Book, Chapter, Verse, Word FROM `Contents` WHERE Word LIKE ?";
		
		
		$chapterCountQuery = "SELECT COUNT(DISTINCT Chapter) FROM `Contents` WHERE Book = ?";

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

		// Keyword query
		$regexKeyword = "/^(\w{3,15})$/";


		$dqo = array();
		// Song of Solomon
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexSolomonChapterVerse, 0));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexSolomonChapterVerseFromVerseTo, 1));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexSolomonChapterFromChapterTo, 2));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexSolomonChapter, 3));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexSolomon, 4));

		// Multiple book names. Example: 2 Peter
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexNumBookBookChapterVerse, 0));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexNumBookBookChapterVerseFromVerseTo, 1));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexNumBookBookChapterFromChapterTo, 2));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexNumBookBookChapter, 3));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexNumBook, 4));

		// Single book names. Example: Genesis
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseQuery, array(), "sii", $regexBookChapterVerse, 0));
		array_push($dqo, new DatabaseQueryObject($bookChapterVerseFromVerseToQuery, array(), "siii", $regexBookChapterVerseFromVerseTo, 1));
		array_push($dqo, new DatabaseQueryObject($bookChapterFromToQuery, array(), "sii", $regexBookChapterFromChapterTo, 2));
		array_push($dqo, new DatabaseQueryObject($bookChapterQuery, array(), "si", $regexBookChapter, 3));
		array_push($dqo, new DatabaseQueryObject($bookQuery, array(), "s", $regexBook, 4));

		// Keyword search
		array_push($dqo, new DatabaseQueryObject($keywordQuery, array(), "s", $regexKeyword, 5));


?>