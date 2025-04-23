import { DataAPI } from "../../api/api";
import { changeDateFormat } from "./functions/changeDateFormat";

const SET_DATA = "court-parser/lib-reducer/SET_DATA";
const SET_STATUS = "court-parser/lib-reducer/SET_STATUS";
const SET_LINK_COUNT = "court-parser/lib-reducer/SET_LINK_COUNT";
const TOGGLE_IS_FETCHING = "court-parser/lib-reducer/TOGGLE_IS_FETCHING";

let initialState = {
  data: {},
  linkCount: 0,
  status: false,
  message: "",
  isFetching: false,
};

const libReducer = (state = initialState, action) => {
  switch (action.type) {
    case SET_DATA:
      return {
        ...state,
        data: action.data.result,
        linkCount: action.data.linkCount,
        message: action.data.message,
      };
    case SET_STATUS:
      return {
        ...state,
        status: action.data.result,
      };
    case SET_LINK_COUNT:
      return {
        ...state,
        linkCount: action.data.results.length,
      };
    case TOGGLE_IS_FETCHING:
      return {
        ...state,
        isFetching: action.isFetching,
      };

    default:
      return state;
  }
};

const setData = (data) => ({ type: SET_DATA, data });
const setStatus = (data) => ({ type: SET_STATUS, data });
const setLinkCount = (data) => ({ type: SET_LINK_COUNT, data });
const toggleIsFetching = (isFetching) => ({ type: TOGGLE_IS_FETCHING, isFetching: isFetching });

export const getProgress = () => {
  return async (dispatch) => {
    dispatch(toggleIsFetching(true));
    const data = await DataAPI.getProgress();
    console.log(data);

    dispatch(toggleIsFetching(false));
    dispatch(setData(data));
  };
};

export const getStatus = () => {
  return async (dispatch) => {
    const data = await DataAPI.getStatus();
    dispatch(setStatus(data));
  };
};

export const updateStatus = (status) => {
  return async (dispatch) => {
    await DataAPI.updateStatus(status);
    const data = await DataAPI.getStatus();
    dispatch(setStatus(data));
  };
};

export const uploadData = (data) => {
  return async (dispatch) => {
    dispatch(toggleIsFetching(true));
    try {
      const responce = await DataAPI.upload(data).catch(console.error);
      console.log(responce);
      dispatch(setLinkCount(responce));

      const status = await DataAPI.getStatus();
      dispatch(setStatus(status));
    } catch (error) {
      throw error;
    } finally {
      dispatch(toggleIsFetching(false));
    }
  };
};

export default libReducer;
