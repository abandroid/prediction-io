import React from 'react';
import Request from 'superagent';
import UserList from './UserList';

class Application extends React.Component {

    constructor(props) {
        super(props);

        this.refresh = this.refresh.bind(this);
        this.initialize = this.initialize.bind(this);
        this.view = this.view.bind(this);
        this.purchase = this.purchase.bind(this);

        this.refresh();

        this.state = { users: [], items: [] };
    }

    refresh() {
        Request
            .get(this.props.statePath)
            .end((error, response) => {
                if (error) {
                    alert('Could not load recommendation data');
                } else {
                    this.setState(response.body);
                    console.log(this.state);
                }
            });
    }

    initialize() {
        Request
            .get(this.props.initializePath)
            .end((error, response) => {
                if (error) {
                    alert('Initialization failed');
                } else {
                    this.refresh();
                }
            });
    }

    view(userId, itemId) {
        Request
            .get(this.props.viewPath.replace('UID', userId).replace('IID', itemId))
            .end((error, response) => {
                if (error) {
                    alert('Could not view item');
                } else {
                    this.refresh();
                }
            });
    }

    purchase(userId, itemId) {
        Request
            .get(this.props.purchasePath.replace('UID', userId).replace('IID', itemId))
            .end((error, response) => {
                if (error) {
                    alert('Could not purchase item');
                } else {
                    this.refresh();
                }
            });
    }

    render() {
        return (
            <div className="row">
                <div className="col-md-12">
                    <div className="box">
                        <div className="box-body">
                            <form className="form-inline">
                                <div className="form-group">
                                    <button type="button" className="btn btn-primary" onClick={() => this.initialize()}>Initialize</button>
                                    &nbsp;
                                    <button type="button" className="btn btn-success" onClick={() => this.refresh()}>Refresh</button>
                                </div>
                            </form>
                            <UserList users={this.state.users} items={this.state.items} recommendations={this.state.recommendations} />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Application;