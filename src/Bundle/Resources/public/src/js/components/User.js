import React from 'react';

class User extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        let message = this.props.message;

        let className = 'table-warning';
        switch (message.translation_key) {
            case 'delivered':
                className = 'table-success';
                break;
            case 'unsent':
            case 'rejected':
            case 'failed':
                className = 'table-danger';
                break;
            default:
                break;
        }

        return (
            <tr>
                <td className={className}>{message.date_created}</td>
                <td className={className}>{message.date_updated}</td>
                <td className={className}>{message.id}</td>
                <td className={className}>{message.body}</td>
                <td className={className}>{message.recipients}</td>
                <td className={className}>{message.translation_key}</td>
            </tr>
        )
    }
}

export default User;