import React from 'react';
import ReactDOM from 'react-dom';
import Application from './components/Application';

ReactDOM.render(
    <Application
        initializePath={appConfig.initializePath}
        statePath={appConfig.statePath}
        viewPath={appConfig.viewPath}
        purchasePath={appConfig.purchasePath}
    />,
    document.getElementById('application')
);