import { connect } from "react-redux";
import UploadComponent from "./UploadComponent";
import { uploadData } from "../../redux/reducers/lib-reducer";

let mapStateToProps = (state) => {
  return {
    data: state.lib.data,
  };
};

let mapDispatchToProps = {
  uploadData,
};

export default connect(mapStateToProps, mapDispatchToProps)(UploadComponent);
