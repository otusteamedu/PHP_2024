import {useEffect, useState, useRef} from "react";

export default function useOutsideClickFrom (currentState) {

    const [openFrom, setOpenFrom] = useState(currentState);
    const refFrom = useRef(null);

    const handleClickOutside = (event) => {
        if (refFrom.current && !refFrom.current.contains(event.target)) {
            setOpenFrom(false);
        }
    }

    useEffect(() => {
        document.addEventListener('click', handleClickOutside, true);
        return () => {
            document.removeEventListener('click', handleClickOutside, true);
        }
    });

    return {refFrom, openFrom, setOpenFrom};

}