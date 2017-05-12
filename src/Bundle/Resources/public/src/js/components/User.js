import React from 'react';
import UserItem from './UserItem';

class User extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        let items = [];
        let component = this;
        _.each(this.props.items, function(item, index) {
            items.push(
                <UserItem
                    key={index}
                    item={item}
                    user={component.props.user}
                    view={component.props.view}
                    purchase={component.props.purchase}
                />
            );
        });

        return (
            <table className="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td><strong>{this.props.user.id}</strong></td>
                        {items}
                    </tr>
                </tbody>
            </table>
        )
    }
}

export default User;