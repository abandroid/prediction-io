import React from 'react';
import Request from 'superagent';
import Alert from 'react-s-alert';
import 'react-s-alert/dist/s-alert-default.css';
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
                    Alert.error('Could not load recommendation data', {
                        position: 'bottom',
                        timeout: 4000
                    });
                } else {
                    this.setState(response.body);
                }
            });
    }

    initialize() {
        Request
            .get(this.props.initializePath)
            .end((error, response) => {
                if (error) {
                    Alert.error('Initialization failed', {
                        position: 'bottom',
                        timeout: 4000
                    });
                } else {
                    Alert.success('Initialized', {
                        position: 'bottom',
                        timeout: 4000
                    });
                    this.refresh();
                }
            });
    }

    view(userId, itemId) {
        Request
            .get(this.props.viewPath.replace('UID', userId).replace('IID', itemId))
            .end((error, response) => {
                if (error) {
                    Alert.error('View action could not be recorded', {
                        position: 'bottom',
                        timeout: 4000
                    });
                } else {
                    Alert.success('View action recorded', {
                        position: 'bottom',
                        timeout: 4000
                    });
                    this.refresh();
                }
            });
    }

    purchase(userId, itemId) {
        Request
            .get(this.props.purchasePath.replace('UID', userId).replace('IID', itemId))
            .end((error, response) => {
                if (error) {
                    Alert.error('Purchase action could not be recorded', {
                        position: 'bottom',
                        timeout: 4000
                    });
                } else {
                    Alert.success('Purchase action recorded', {
                        position: 'bottom',
                        timeout: 4000
                    });
                    this.refresh();
                }
            });
    }

    render() {
        return (
            <div className="row">
                <Alert stack={{ limit: 3 }} />
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
                            <br />
                            <UserList
                                users={this.state.users}
                                items={this.state.items}
                                view={this.view}
                                purchase={this.purchase}
                            />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Application;