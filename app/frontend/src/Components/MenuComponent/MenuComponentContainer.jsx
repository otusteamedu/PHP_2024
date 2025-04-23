import { connect } from "react-redux";
import MenuComponent from "./MenuComponent";
import { getProgress } from "../../redux/reducers/lib-reducer";

let mapStateToProps = (state) => {
  return {
    data: state.lib.data,
    status: state.lib.status,
  };
};

let mapDispatchToProps = {
  getProgress,
};

export default connect(mapStateToProps, mapDispatchToProps)(MenuComponent);
