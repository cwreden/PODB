'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}

PODB.Application = React.createClass({
    render: function() {
        var NavigationBar = PODB.component.NavigationBar;
        var RouteHandler = ReactRouter.RouteHandler;
        return (
            <div>
                <NavigationBar/>
                <div id="content" className="container centered">
                    <RouteHandler/>
                </div>
            </div>
        );
    }
});
