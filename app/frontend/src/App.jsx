import React from "react";
import { connect } from "react-redux";
import { BrowserRouter } from "react-router-dom";
import "primereact/resources/primereact.min.css";
import "/node_modules/primeflex/primeflex.css";
import "./App.css";

import { initializeApp } from "./redux/reducers/app-reducer";
import MenuComponentContainer from "./Components/MenuComponent/MenuComponentContainer";
import AnimatedRoutes from "./AnimatedRoutes";
import { getStatus } from "./redux/reducers/lib-reducer";

class App extends React.Component {
  async componentDidMount() {
    await this.props.initializeApp();
    await this.props.getStatus();
  }

  render() {
    return (
      <BrowserRouter>
        <div className="app-wrapper">
          <MenuComponentContainer />
          <AnimatedRoutes />
        </div>
      </BrowserRouter>
    );
  }
}

const mapStateToProps = (state) => ({
  initialized: state.app.initialized,
});

export default connect(mapStateToProps, { initializeApp, getStatus })(App);
