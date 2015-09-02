'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.Project = React.createClass({
    getInitialState: function() {
        return {
            data: [],
            translations: [{
                id: 1,
                msgStr: "Der Lolli Troll",
                message: {
                    id: 1,
                    msgId: "Lollipop Troll"
                },
                _links: {
                    self: "/api/v1/translation/1"
                }
            }]
        };
    },
    changeLanguage: function (language) {
        this.refs.translationList.setLanguage(language);
    },
    changeDomain: function () {
        console.log('Domain', arguments);
        // TODO
    },
    load: function () {
        $.ajax({
            url: '/api/v1/project/' + this.props.params.project,
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({
                    data: data,
                    translations: this.state.translations
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
    render: function () {
        var Grid = ReactBootstrap.Grid;
        var Row = ReactBootstrap.Row;
        var Col = ReactBootstrap.Col;
        var DropdownButton = ReactBootstrap.DropdownButton;
        var MenuItem = ReactBootstrap.MenuItem;
        var LanguageSelectButton = PODB.component.LanguageSelectButton;
        var DomainSelectButton = PODB.component.DomainSelectButton;
        var TranslationList = PODB.component.TranslationList;
        /*

         */
        return (
            <div className="repository">
                <h2>{this.props.params.owner}/{this.props.params.project}</h2>
                <LanguageSelectButton onSelect={this.changeLanguage}></LanguageSelectButton>
                <DomainSelectButton onSelect={this.changeDomain} project={this.props.params.project}></DomainSelectButton>
                <TranslationList project={this.props.params.project} ref='translationList'></TranslationList>
            </div>
        );
    }
});
