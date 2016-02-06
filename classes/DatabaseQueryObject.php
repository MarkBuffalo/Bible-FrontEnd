<?php
	class DatabaseQueryObject
	{
		function __construct($query, $parameters, $parameterTypes, $regex, $queryType, $lang)
		{
			$this->query = $query;
			$this->parameters = $parameters;
			$this->parameterTypes = $parameterTypes;
			$this->regex = $regex;
			$this->queryType = $queryType;
			$this->lang = $lang;
		}

		public $query;
		public $parameters;
		public $parameterTypes;
		public $regex;
		public $queryType;
		public $lang;
	}
?>