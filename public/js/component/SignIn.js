'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.SignIn = React.createClass({
    mixins: [React.addons.LinkedStateMixin],
    getInitialState: function() {
        return {
            user: '',
            password: ''
        };
    },

    login: function (e) {
        e.preventDefault();
        console.info('login not implemented!', this.state.user, this.state.password);
        //$.ajax({
        //    url: '/users/' + this.props.owner + '/repos',
        //    dataType: 'json',
        //    cache: false,
        //    success: function(data) {
        //        this.setState({data: data});
        //    }.bind(this),
        //    error: function(xhr, status, err) {
        //        console.error(this.props, status, err);
        //    }.bind(this)
        //});
    },

    render: function () {
        return (
            <div className="login jumbotron center-block" width="200px">
                <h2>Sign In</h2>
                <form role="form">
                    <div className="form-group">
                        <label htmlFor="username">Username</label>
                        <input type="text" valueLink={this.linkState('user')} className="form-control" id="username" placeholder="Username" />
                    </div>
                    <div className="form-group">
                    <label htmlFor="password">Password</label>
                    <input type="password" valueLink={this.linkState('password')} className="form-control" id="password" ref="password" placeholder="Password" />
                </div>
                <button type="submit" className="btn btn-default" onClick={this.login}>Submit</button>
            </form>
        </div>
        );
    }
});
