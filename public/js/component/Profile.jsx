'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.Profile = React.createClass({
    render: function () {
        var TabbedArea = ReactBootstrap.TabbedArea;
        var TabPane = ReactBootstrap.TabPane;
        var ProjectList = PODB.component.ProjectList;
        return (
            <div className="profile">
                <h2>{this.props.params.owner}</h2>
                <TabbedArea defaultActiveKey={1}>
                    <TabPane eventKey={1} key={1} tab="Own Projects">
                        <ProjectList owner={this.props.params.owner} own={true}/>
                    </TabPane>
                    <TabPane eventKey={2} key={2} tab="Contributed Projects">
                        <ProjectList owner={this.props.params.owner}/>
                    </TabPane>
                </TabbedArea>
            </div>
        );
    }
});
