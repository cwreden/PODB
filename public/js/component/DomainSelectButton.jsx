'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.DomainSelectButton = React.createClass({
    getInitialState: function() {
        return {
            selected: null,
            data: []
        };
    },
    load: function() {
        if (typeof this.props.project === 'undefined') {
            return;
        }
        $.ajax({
            url: '/api/v1/project/' + this.props.project + '/domain',
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({
                    selected: this.state.selected,
                    data: data
                });
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.props, status, err);
            }.bind(this)
        });
    },
    componentDidMount: function() {
        this.load();
    },
    select: function (key) {
        var domain = this.state.data[key];
        if (domain === this.state.selected) {
            return;
        }
        this.setState({
            selected: domain,
            data: this.state.data
        });
        if (typeof this.props.onSelect === 'function') {
            this.props.onSelect(domain);
        }
    },
    selectNone: function () {
        this.setState({
            selected: null,
            data: this.state.data
        });
        if (typeof this.props.onSelectNone === 'function') {
            this.props.onSelectNone();
        } else if (typeof this.props.onSelect === 'function') {
            this.props.onSelect(null);
        }
    },
    render: function () {
        var me = this;
        var DropdownButton = ReactBootstrap.DropdownButton;
        var MenuItem = ReactBootstrap.MenuItem;
        var items = this.state.data.map(function (row, index) {
            if (row.id === me.state.data.id) {
                return (<MenuItem key={row.id} eventKey={index} onSelect={me.select} active={true}>{row.name}</MenuItem>)
            }
            return (<MenuItem key={row.id} eventKey={index} onSelect={me.select}>{row.name}</MenuItem>)
        });
        var selectedName = 'None';
        if (this.state.selected !== null) {
            selectedName = this.state.selected.name;
        }
        return (
            <DropdownButton title={selectedName}>
                <MenuItem key='none' eventKey='none' onSelect={me.selectNone}>None</MenuItem>
            {items}
            </DropdownButton>
        );
    }
});
