import {combineReducers, configureStore} from '@reduxjs/toolkit'
import signReducer from "./slices/signSlice"
import userReducer from "./slices/userSlice"

const rootReducer = combineReducers({
    sign: signReducer,
    user: userReducer
})

export const store = configureStore({
    reducer: rootReducer,
})