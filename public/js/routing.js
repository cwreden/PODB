'use strict';

var Router = ReactRouter;
var Route = Router.Route;
var DefaultRoute = Router.DefaultRoute;
var NotFoundRoute = Router.NotFoundRoute;

var NotFound = React.createClass({
    render: function () {
        return <h2>Not Found!</h2>;
    }
});

var routes = (
    <Route handler={PODB.Application}>
        <Route path="Sign/In" handler={PODB.component.SignIn}/>
        <Route path="Home" handler={PODB.component.Home}/>
        <Route path="Dashboard" handler={PODB.component.Dashboard}/>
        <Route path="Users" handler={PODB.component.Users}/>
        <Route path="User/:owner" handler={PODB.component.Profile}/>
        <Route path="User/:owner/:project" handler={PODB.component.Project}/>
        <DefaultRoute handler={PODB.component.Home}/>
        <NotFoundRoute handler={NotFound}/>
    </Route>
);

Router.run(routes, Router.HashLocation, function(Root) {
    React.render(<Root/>, document.body);
});
