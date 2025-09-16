# mvc-mini
Base MVC for mini application using php native


<h2>Routes</h2>
If you don't have any sub folder on controllers <br>
<span style="color: lightgreen">$router->get('/', 'HomeController@index');</span>

If you have any sub folder on controllers, backOffice it's the namespace of the controller <br>
<span style="color: lightgreen">$router->get('/', '\backOffice\HomeController@index');</span>