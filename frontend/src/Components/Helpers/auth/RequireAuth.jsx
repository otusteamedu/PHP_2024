import { useLocation, Navigate } from 'react-router-dom';

const RequireAuth = ({children}) => {
    const location = useLocation();
    const auth = false;
    if (!auth) {
        return <Navigate to='/sign/' state={{from:location }} replace={true} />
    }

    return children;
}

export {RequireAuth};