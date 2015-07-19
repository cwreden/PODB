'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.Users = React.createClass({
    render: function () {
        var UserList = PODB.component.UserList;
        return (
            <div className="profile">
                <h2>User List</h2>
                <UserList/>
            </div>
        );
    }
});
