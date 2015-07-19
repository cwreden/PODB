'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.UserList = React.createClass({
    getInitialState: function() {
        return {data: []};
    },
    load: function() {
        var url = '/api/v1/user';
        $.ajax({
            url: url,
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({data: data});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.props, status, err);
            }.bind(this)
        });
    },
    componentDidMount: function() {
        this.load();
    },
    render: function() {
        var me = this;
        var ListGroup = ReactBootstrap.ListGroup;
        var nodes = this.state.data.map(function (data) {
            var ListGroupItem = ReactBootstrap.ListGroupItem;
            var link = '/#/User/' + data.username;
            return (
                <ListGroupItem key={data.id} header={data.displayName} href={link}>{data.username}</ListGroupItem>
            );
        });
        return (
            <ListGroup className="repositoryList">
                {nodes}
            </ListGroup>
        );
    }
});
