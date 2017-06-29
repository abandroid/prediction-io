import React from 'react';

class UserItem extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <td>
                <img width="150" height="225" src={"/bundles/endroidpredictioniodemo/images/{IID}.jpg".replace('{IID}', this.props.item.id)} />
                &nbsp;
                <button type="button" className="btn btn-primary btn-sm" onClick={() => this.props.view(this.props.user.id, this.props.item.id)}>view</button>
                &nbsp;
                <button type="button" className="btn btn-primary btn-sm" onClick={() => this.props.purchase(this.props.user.id, this.props.item.id)}>purchase</button>
                &nbsp;
                <span className="recommendation">{this.props.recommendation.toFixed(3)}</span>
            </td>
        )
    }
}

export default UserItem;