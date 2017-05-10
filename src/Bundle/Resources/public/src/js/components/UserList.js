import React from 'react';
import _ from 'lodash';
import User from './User';

class UserList extends React.Component {

    constructor(props) {
        super(props);

        this.state = { users: [], items: [] }
    }

    render() {
        let users = [];
        _.each(this.props.messages, function(user, index) {
            users.push(
                <User
                    key={index}
                    user={user}
                    items={items}
                />
            );
        });

        return (
            <table className="table table-bordered" id="message-list">
                <thead>
                    <tr>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Reference</th>
                        <th>Message</th>
                        <th>Recipients</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {messages}
                </tbody>
            </table>
        )
    }
}

export default UserList;
