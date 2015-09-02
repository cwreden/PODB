'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.TranslationList = React.createClass({
    getInitialState: function() {
        return {
            showModal: false,
            selectedTranslation: null,
            data: []
        };
    },
    load: function() {
        if (typeof this.props.project !== 'string' || typeof this.locale !== 'string') {
            return;
        }
        var url = '/api/v1/project/' + this.props.project + '/translation/' + this.locale;
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
    setLanguage: function (language) {
        this.locale = language.locale;
        this.load();
    },
    editTranslation: function (index, id) {
        var translation = this.state.data[index];
        console.log('edit', index, id, translation);
        this.setState({
            showModal: true,
            selectedTranslation: translation
        });
    },
    close: function () {
        console.log('close');
        this.setState({
            showModal: false
        });
    },
    render: function() {
        var me = this;
        var ListGroup = ReactBootstrap.ListGroup;
        var ListGroupItem = ReactBootstrap.ListGroupItem;
        //var Modal = ReactBootstrap.Modal;
        //var Button = ReactBootstrap.Button;

        var nodes = this.state.data.map(function (data, index) {
            return (
                <ListGroupItem key={data.id} header={data.msgStr} onClick={me.editTranslation.bind(me, index, data.id)}>{data.message.msgId}</ListGroupItem>
            );
        });

        // TODO modal editor
        /*
         <Modal show={this.state.showModal} onHide={this.close} onRequestClose={this.close} onRequesthide={this.close}>
         <Modal.Header closeButton>
         <Modal.Title>Translate</Modal.Title>
         </Modal.Header>
         <Modal.Body>
         test
         </Modal.Body>
         <Modal.Footer>
         <Button onClick={this.close}>Close</Button>
         <Button bsStyle='primary'>Save changes</Button>
         </Modal.Footer>
         </Modal>
         */
        return (
            <div>
                <ListGroup className="translationList">
                    {nodes}
                </ListGroup>

            </div>
        );
    }
});
