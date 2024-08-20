import {useEffect, useState, useRef} from "react";

export default function useOutsideClickTo (currentState) {

    const [openTo, setOpenTo] = useState(currentState);
    const refTo = useRef(null);

    const handleClickOutside = (event) => {
        if (refTo.current && !refTo.current.contains(event.target)) {
            setOpenTo(false);
        }
    }

    useEffect(() => {
        document.addEventListener('click', handleClickOutside, true);
        return () => {
            document.removeEventListener('click', handleClickOutside, true);
        }
    });

    return {refTo, openTo, setOpenTo};

}