import { createContext, useState } from "react";

export const AuthContext = createContext(null);

export const AuthProvider = ({children}) => {
    return <AuthContext.provider>
        {children}
    </AuthContext.provider>
}