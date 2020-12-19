import React, { Component } from "react";
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import { render } from "react-dom";
import DynamicRoutes from './DynamicRoutes';
import DynamicLinks from './DynamicLinks';

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
    };
  }

  render() {
    return (
          <div>
            <DynamicLinks />
            <Router>
              <DynamicRoutes />
            </Router>
          </div>
    );
  }
};

export default App;

