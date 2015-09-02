'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.LanguageSelectButton = React.createClass({
    getInitialState: function() {
        return {
            language: null,
            languages: [{
                id: 1,
                name: "Deutsch",
                locale: "de_DE",
                _links: {
                    self: "/api/v1/language/de_DE"
                }
            }]
        };
    },
    load: function() {
        $.ajax({
            url: '/api/v1/language',
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({
                    languages: data
                });
                if (this.state.language === null && data.length > 0) {
                    this.selectLanguage(0);
                }
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.props, status, err);
            }.bind(this)
        });
    },
    componentDidMount: function() {
        this.load();
    },
    selectLanguage: function (key) {
        var language = this.state.languages[key];
        if (language === this.state.language) {
            return;
        }
        this.setState({
            language: language
        });
        if (typeof this.props.onSelect === 'function') {
            this.props.onSelect(language);
        }
    },
    render: function () {
        var me = this;
        var DropdownButton = ReactBootstrap.DropdownButton;
        var MenuItem = ReactBootstrap.MenuItem;

        var selectedLanguage = this.state.language;
        var items = this.state.languages.map(function (row, index) {
            if (selectedLanguage !== null && row.locale === selectedLanguage.locale) {
                return (<MenuItem key={row.locale} eventKey={index} onSelect={me.selectLanguage} active={true}>{row.name}</MenuItem>)
            }
            return (<MenuItem key={row.locale} eventKey={index} onSelect={me.selectLanguage}>{row.name}</MenuItem>)
        });
        var selectedName = 'Language';
        if (selectedLanguage !== null) {
            selectedName = selectedLanguage.name;
        }
        return (
            <DropdownButton title={selectedName}>
            {items}
            </DropdownButton>
        );
    }
});
