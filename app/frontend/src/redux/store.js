import { applyMiddleware, combineReducers, legacy_createStore as createStore, compose } from "redux";
import appReducer from "./reducers/app-reducer";
import { thunk } from "redux-thunk";
import libReducer from "./reducers/lib-reducer";

let reducers = combineReducers({
  lib: libReducer,
  app: appReducer,
});

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
let store = createStore(reducers, composeEnhancers(applyMiddleware(thunk)));

window.state = store.getState();

export default store;
