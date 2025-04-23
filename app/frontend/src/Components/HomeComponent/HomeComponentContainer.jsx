import { connect } from "react-redux";
import HomeComponent from "./HomeComponent";
import { uploadData } from "../../redux/reducers/lib-reducer";

let mapStateToProps = (state) => {
  return {
    data: state.lib.data,
  };
};

let mapDispatchToProps = {
  uploadData,
};

export default connect(mapStateToProps, mapDispatchToProps)(HomeComponent);
