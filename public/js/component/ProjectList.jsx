'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.ProjectList = React.createClass({
    getInitialState: function() {
        return {data: []};
    },
    load: function() {
        var url = '/api/v1/user/' + this.props.owner;
        if (this.props.own === true) {
            url += '/own';
        }
        url += '/projects';
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
            var link = '/#/User/' + me.props.owner + '/' + data.name;
            return (
                <ListGroupItem key={data.id} header={data.name} href={link}>{data.description}</ListGroupItem>
            );
        });
        return (
            <ListGroup className="repositoryList">
                {nodes}
            </ListGroup>
        );
    }
});
