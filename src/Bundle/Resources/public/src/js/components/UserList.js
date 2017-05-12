import React from 'react';
import _ from 'lodash';
import User from './User';

class UserList extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        let users = [];
        let component = this;
        _.each(this.props.users, function(user, index) {
            users.push(
                <User
                    key={index}
                    user={user}
                    items={component.props.items}
                    view={component.props.view}
                    purchase={component.props.purchase}
                />
            );
        });

        return (
            <div className="table-responsive">
                {users}
            </div>
        )
    }
}

export default UserList;
