<?php
	// A file to handle routing to seperate files to make it more SEO friendly
	class SimpleRouter {
		protected $routes = []; // stores routes
		
		public function addRoute(string $method, string $url, closure $target) {
			$this->routes[$method][$url] = $target;
		}

		public function matchRoute() {
			$method = $_SERVER['REQUEST_METHOD'];
			$url = $_SERVER['REQUEST_URI'];
			if (isset($this->routes[$method])) {
					foreach ($this->routes[$method] as $routeUrl => $target) {
						// use pattern matching to match any and store the value in variable
						$pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
						if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
								// pass a captured parameter as named arguments
								$params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Only keep named subpattern matches
								call_user_func_array($target, $params);
								return;
						}
				}
			} else {
				throw new Exception('Route not found');
			}
		}
	}
?>
