<?php

		// Split the the string into an array based on regex capture groups.
		function getPregSplitArray($pattern, $str)
		{
			return preg_split($pattern, $str, -1, PREG_SPLIT_DELIM_CAPTURE);
		}

		// This is where we determine whether or not the query is valid before sending it to the database.
		function checkSearchType($search)
		{
			global $dqo;
			
			foreach ($dqo as $d)
			{
				// Our DatabaseQueryObject properties
				$query = $d->query;
				$parameters = $d->parameters;
				$parameterTypes = $d->parameterTypes;
				$regex = $d->regex;
				$queryType = $d->queryType;

				// Is it one of our valid queries, and *NOT* a keyword search?
				if ($queryType != 5 && preg_match($regex, $search))
				{
					// We've got a match. Split the query into an array based on regex capture groups.
					$contents = getPregSplitArray($regex, $search);

					// How big is our array?
					$conCount = count($contents);

					// This is where we'll put the temporary parameters once we've removed the empty ones.
					$tmpParameters = array();

					// Remove bad elements and insert into new array, $parameters.
					for ($i = 0; $i < $conCount; $i++)
					{
						// If it's not the first or last option (both of which are empty when using preg_split()), add it to the parameter list.
						if ($i != 0 && $i != ($conCount - 1))
						{
							array_push($tmpParameters, $contents[$i]);
						}
					}

					// This query was for Song of Solomon. Combine tmpParameters[0], tmpParameters[1], and tmpParameters[2] to create a single book.
					if (strtolower($tmpParameters[0]) == "song")
					{
						// Combine the full book name.
						$bookName = $tmpParameters[0] . " " . $tmpParameters[1] . " " . $tmpParameters[2];

						array_push($parameters, $bookName);

						for ($j = 0; $j < count($tmpParameters); $j++)
						{
							// Make sure we skip the book name. We already combined that.
							if ($j != 0 && $j != 1 && $j != 2)
							{
								array_push($parameters, $tmpParameters[$j]);
							}
						}
					} // Found a number book. Example: 2 Peter. Combine tmpParameters[0] and tmpParameters[1].
					else if (is_numeric($tmpParameters[0]))
					{
						// Combine the full book name.
						$bookName = $tmpParameters[0] . " " . $tmpParameters[1];

						array_push($parameters, $bookName);

						for ($j = 0; $j < count($tmpParameters); $j++)
						{
							// Make sure we skip the book name. We already combined that.
							if ($j != 0 && $j != 1)
							{
								array_push($parameters, $tmpParameters[$j]);
							}
						}
					} // Book without multiple accompanying books. Example: Genesis.
					else if (is_string($tmpParameters[0]))
					{
						$parameters = $tmpParameters;
					}

					// Everything looks good. Let's start the parameterization process, and return the results to the visitor.
					$results = queryDatabase($query, $parameters, $parameterTypes, $queryType);

					// Found something
					if (strlen($results) > 10)
					{
						return $results;
					}
				}
				else if (preg_match($regex, $search) && $queryType == 5)
				{
					$results = queryDatabase($query, array($search), $parameterTypes, $queryType);
					if (strlen($results) > 10)
					{
						return $results;
					}
				}
			}
			return "No results found.";
		}


		function queryDatabase($query, $parameters, $parameterType, $queryType)
		{
			global $servername;
			global $databasename;
			global $username;
			global $password;

			$results = "";

			$db = new mysqli($servername, $username, $password, $databasename);
			$stmt = $db->prepare($query);

			switch ($queryType)
			{
				case 0: // bookChapterVerse
				{
					$stmt->bind_param($parameterType, $parameters[0], $parameters[1], $parameters[2]); // sii
				} break;
				
				case 1: // bookChapterVerseFromVerseTo
				{
					// To can't be greater than From. Example: Genesis 2-1 is invalid. This does not allow you to search backwards.
					if ($parameters[2] > $parameters[3])
					{
						// Free up resources.
						$stmt->free_result();
						$stmt->close();
						return "VerseTo can't be greater than VerseFrom.";
					}
					$stmt->bind_param($parameterType, $parameters[0], $parameters[1], $parameters[2], $parameters[3]); // siii
				} break;
				
				case 2: // bookChapterFromChapterTo
				{
					// To can't be greater than From. Example: Genesis 2-1 is invalid. This does not allow you to search backwards.
					if ($parameters[1] > $parameters[2])
					{
						// Free up resources.
						$stmt->free_result();
						$stmt->close();
						return "ChapterTo can't be greater than ChapterFrom.";
					}

					$stmt->bind_param($parameterType, $parameters[0], $parameters[1], $parameters[2]); // sii
				} break;
				
				case 3: // bookChapter
				{
					$stmt->bind_param($parameterType, $parameters[0], $parameters[1]); // si
				} break;
				
				case 4: // Book
				{
					$stmt->bind_param($parameterType, $parameters[0]); // s
				} break;
				case 5: // Non-book-based search. Allows searching words. 
				{
					$fixedParameter = "%" . $parameters[0] . "%";
					$stmt->bind_param($parameterType, $fixedParameter); // s
				}break;
				
				default:
				{
					// Free up resources.
					$stmt->free_result();
					$stmt->close();

					die("Incorrect value entered");
				} break;
			}
			$stmt->execute();


			$stmt->store_result();
			$stmt->bind_result($BookName, $Chapter, $Verse, $Word);

			$numResults = 0;

			// Print results.
			if ($queryType != 5)
			{
				while ($stmt->fetch())
				{
					// Return database column results.
					$results .= $BookName . " " . $Chapter . ":" . $Verse . " - " . $Word . " <br/>";
					$numResults++;
				}
			}
			
			// Query contains user-defined search. Must sanitize output. If attacker somehow gets past validation, this is the last line of defense.
			// While our database will not find anything that could be used for XSS, and therefore not return anything, this would be sloppy coding if I didn't account for it.
			else
			{
				while ($stmt->fetch())
				{
					$results .= $BookName . " " . $Chapter . ":" . $Verse . " - " . str_replace(htmlentities($parameters[0]), "<strong>".htmlentities($parameters[0])."</strong>", $Word) . " <br/>";
					$numResults++;
				}
			}


			// Free up resources.
			$stmt->free_result();
			$stmt->close();

			if ($numResults == 0)
			{
				return $numResults;
			}

			// Send the data back to checkSearch()
			return $results;
		}
?>