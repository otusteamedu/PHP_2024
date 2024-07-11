import Logo from 'images/logo.svg';
import React from 'react';
import {Link} from "react-router-dom";


export default function Header() {
    const projectName = "Coinschest";


    return (<>
        <header className="header">

            <div className="container">

                <div className="header-row">

                    <div className="header-logo">
                        <Link to="/" title={projectName}>
                            <div className="header-logo-img">
                                <img src={Logo} alt="Logo" />
                            </div>
                            <div className="header-logo-text">{projectName}</div>
                        </Link>
                    </div>

                </div>
            </div>
        </header>
    </>);

}




