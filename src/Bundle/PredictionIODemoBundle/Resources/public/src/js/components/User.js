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
            let score = 0;
            _.each(component.props.user.recommendations.itemScores, function(recommendation, index) {
                if (recommendation.item === item.id) {
                    score = recommendation.score;
                }
            });
            items.push(
                <UserItem
                    key={index}
                    item={item}
                    user={component.props.user}
                    recommendation={score}
                    view={component.props.view}
                    purchase={component.props.purchase}
                />
            );
            items.sort(function(itemA, itemB) {
                return itemB.props.recommendation - itemA.props.recommendation;
            });
        });

        return (
            <table className="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td><strong>User {this.props.user.id}</strong></td>
                        {items}
                    </tr>
                </tbody>
            </table>
        )
    }
}

export default User;