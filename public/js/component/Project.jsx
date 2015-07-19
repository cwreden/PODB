'use strict';

if (typeof PODB === 'undefined') {var PODB = {};}
if (typeof PODB.component === 'undefined') {PODB.component = {};}

PODB.component.Project = React.createClass({
    render: function () {
        var Grid = ReactBootstrap.Grid;
        var Row = ReactBootstrap.Row;
        var Col = ReactBootstrap.Col;
        return (
            <div className="repository">
                <h2>{this.props.params.owner}/{this.props.params.project}</h2>
                <Grid>
                    <Row className='show-grid'>
                    </Row>
                </Grid>
            </div>
        );
    }
});
