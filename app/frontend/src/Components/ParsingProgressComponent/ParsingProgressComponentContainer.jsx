import { connect } from "react-redux";
import ParsingProgressComponent from "./ParsingProgressComponent";
import { getProgress } from "../../redux/reducers/lib-reducer";

let mapStateToProps = (state) => {
  return {
    data: state.lib.data,
    linkCount: state.lib.linkCount,
  };
};

let mapDispatchToProps = {
  getProgress,
};

export default connect(mapStateToProps, mapDispatchToProps)(ParsingProgressComponent);
