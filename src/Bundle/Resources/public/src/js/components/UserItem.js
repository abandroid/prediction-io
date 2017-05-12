import React from 'react';

class UserItem extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        for (let i = 0; i < this.props.user.recommendations.length; i++) {
            let recommendation = this.props.user.recommendations[i];
            console.log(recommendation);
        }

        return (
            <td>
                <strong>{this.props.item.id}</strong>
                &nbsp;
                <span className="fa fa-eye" aria-hidden="true" onClick={() => this.props.view(this.props.user.id, this.props.item.id)}>E</span>
                &nbsp;
                <span className="fa fa-search" aria-hidden="true" onClick={() => this.props.purchase(this.props.user.id, this.props.item.id)}>P</span>
                &nbsp;
                <span className="recommendation"></span>
            </td>
        )
    }
}

export default UserItem;