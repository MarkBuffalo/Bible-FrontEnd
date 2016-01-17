<?php
		class DatabaseQueryObject
		{
			function __construct($query, $parameters, $parameterTypes, $regex, $queryType)
			{
				$this->query = $query;
				$this->parameters = $parameters;
				$this->parameterTypes = $parameterTypes;
				$this->regex = $regex;
				$this->queryType = $queryType;
			}

			public $query;
			public $parameters;
			public $parameterTypes;
			public $regex;
			public $queryType;
		}
?>