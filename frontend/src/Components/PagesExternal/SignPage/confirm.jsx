import React from "react";
import {pageLogin} from "../../../redux/slices/signSlice";
import {useDispatch} from "react-redux";
import PostServices from "../../Helpers/PostServices";
import {SIGN_CONFIRM, SIGN_PAGE} from "./Constants";
import { Formik, Form, Field } from "formik";
import { Navigate , useNavigate } from 'react-router-dom';
import {confirmValidation} from "../../Helpers/validation/confirmValidation";


export const Confirm = ({email}) => {

    const navigate = useNavigate();
    const dispatch = useDispatch();
    const [errorCode, setErrorCode] = React.useState('');
    const [redirect, setRedirect] = React.useState(null);

    async function sendForm(values) {
        let fData = new FormData();
        fData.append('page', SIGN_PAGE);
        fData.append('type', SIGN_CONFIRM);
        fData.append('code', values.code);
        fData.append('email', email);
        await PostServices.sendForm(fData)
            .then(res => {
                console.log(res);
                if (res.redirect && res.userEmail) {
                    // dispatch(setUser({accessToken: res.accessToken, userId: res.userId }));
                    localStorage.setItem("userEmail", res.userEmail)
                    setRedirect(res.redirect);
                }
                // else dispatch(loqOut());

                if (res.error) setErrorCode(res.error);
            })
            .catch(error => console.log(error))
    }

    React.useEffect(() => {
        if (redirect) navigate("/" + redirect + "/");
    }, [ redirect ]);



    return (
        <>
            <div className="page_head">
                <div className="log_head_title">
                    <h2>Вход</h2>
                </div>
            </div>
            <div className="page_body">

                    <Formik
                        validationSchema={confirmValidation}
                        initialValues={{code: ''}}
                        onSubmit={values =>{
                            sendForm(values)
                        }}
                    >
                        { ({ errors , touched}) => (

                                <Form>
                                    <div className="log_body_sign_code">
                                        <div className="log_b_s_c_label">
                                            {
                                                errorCode ? (<span className="red">{errorCode}</span>)
                                                    : (<p>Код отправлен на {email}</p>)
                                            }
                                            <a href="#" onClick={() => dispatch(pageLogin())}>Изменить Email</a>

                                            <Field
                                                className="log_body_sin_input"
                                                placeholder="Код"
                                                name="code"
                                                //inputMode="numeric"
                                            />

                                            { errors.code && touched.code && (
                                                <span className="red">{errors.code}</span>
                                            )}

                                            <button
                                                type="submit"
                                                className="yellow_btn log_body_sin_btn"
                                            ><span>Войти</span></button>

                                            <p className="opacity50">Отправить повторно {47}</p>
                                        </div>
                                    </div>
                                </Form>

                            )
                        }

                    </Formik>


            </div>
        </>
    )
}