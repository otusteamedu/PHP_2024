import React from "react";
import {useDispatch} from "react-redux";
import {pageRegister} from "../../../redux/slices/signSlice";
import PostServices from "../../Helpers/PostServices";
import {Field, Form, Formik} from "formik";
import {signValidation} from "../../Helpers/validation/signValidation";
import {SIGN_LOGIN, SIGN_PAGE} from "./Constants";
import { Navigate , useNavigate } from 'react-router-dom';



export const Login = () => {
    const [error, setError] = React.useState('');
    const [errorCode, setErrorCode] = React.useState('');
    const [redirect, setRedirect] = React.useState(null);

    const navigate = useNavigate();
    const dispatch = useDispatch();

    React.useEffect(() => {
        if (redirect) navigate("/" + redirect + "/");
    }, [ redirect ]);

    async function sendForm(values) {

        let fData = new FormData();
        fData.append('page', SIGN_PAGE);
        fData.append('type', SIGN_LOGIN);
        fData.append('email', values.email);
        fData.append('password', values.password);

        await PostServices.sendForm(fData)
            .then(res => {
                if (res.status === 3) {
                    localStorage.setItem("userEmail", res.userEmail);
                    setRedirect(res.redirect);
                }
                if (res.error) setErrorCode(res.error);
            })
            .catch(error => console.log(error))
    }



    return (
        <>
            <div className="page_head">
                <div className="log_head_title">
                    <h2>Вход</h2>
                </div>
            </div>
            <div className="page_body">

                    <Formik
                        validationSchema={signValidation}
                        initialValues={{email: '', password: ''}}
                        onSubmit={values => {
                            sendForm(values)
                        }}
                    >
                        {
                            ({ errors, touched }) => (

                                <Form>
                                    <div className="log_body_signin">

                                        {
                                            error && (
                                                <span className="red">{error}</span>
                                            )
                                        }

                                        <Field
                                            autoComplete = "off"
                                            className="log_body_sin_input"
                                            placeholder="E-mail"
                                            name = "email"
                                        />
                                            {
                                                errors.email && touched.email && (
                                                    <span className="red">{errors.email}</span>
                                                )
                                            }

                                        <Field
                                            type="password"
                                            autoComplete = "off"
                                            className="log_body_sin_input"
                                            placeholder="Пароль"
                                            name = "password"
                                        />
                                        {
                                            errors.password && touched.password && (
                                                <span className="red">{errors.password}</span>
                                            )
                                        }

                                        <button
                                            type="submit"
                                            className="yellow_btn log_body_sin_btn"
                                        ><span>Войти</span></button>
                                    </div>
                                </Form>

                            )

                        }

                    </Formik>

                <div className="log_body_signup"><a href='#' onClick={() => dispatch(pageRegister()) }>Зарегистрироваться</a></div>
            </div>
        </>
    )
}
