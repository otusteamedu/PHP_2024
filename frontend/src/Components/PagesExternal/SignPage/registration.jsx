import React from "react";
import PostServices from "../../Helpers/PostServices";
import { useDispatch } from "react-redux";
import { pageConfirm } from "../../../redux/slices/signSlice";
import { Formik, Form , Field } from "formik";
import {SIGN_PAGE, SIGN_REGISTER} from "./Constants";
import {signValidation} from "../../Helpers/validation/signValidation";


export const Registration = () => {

    const dispatch = useDispatch();

    async function sendForm(values) {
        let fData = new FormData();
        fData.append('page', SIGN_PAGE);
        fData.append('type', SIGN_REGISTER);
        fData.append('email', values.email);
        fData.append('password', values.password);
        await PostServices.sendForm(fData)
            .then(res => {
                //console.log(res)
                if (res) dispatch(pageConfirm())
            })
            .catch(error => console.log(error))
    }

    return (
        <>

            <div className="page_head">
                <div className="log_head_title">
                    <h2>Регистрация</h2>
                </div>
            </div>

            <div className="page_body">

                <Formik
                    validationSchema={signValidation}
                    initialValues={
                        {email: '', password: ''}
                    }
                    onSubmit={values => {sendForm(values)}}
                >
                    { ({errors,touched}) => (

                            <Form>

                                <div className="log_body_signin">

                                    <Field
                                        className="log_body_sin_input"
                                        placeholder="E-mail"
                                        name="email"
                                    />
                                    {
                                        errors.email && touched.email && (
                                            <span className="red">{errors.email}</span>
                                        )
                                    }

                                    <Field
                                        type="password"
                                        className="log_body_sin_input"
                                        placeholder="Пароль"
                                        name="password"
                                    />
                                    {
                                        errors.password && touched.password && (
                                            <span className="red">{errors.password}</span>
                                        )
                                    }

                                    <button
                                        type="submit"
                                        className="yellow_btn log_body_sin_btn"
                                    ><span>Зарегистрироваться</span></button>
                                </div>

                            </Form>
                        )
                    }

                </Formik>

                <div className="accept_legal"><p>Регистрация аккаунта Coinschest означает ваше согласие с Политикой конфиденциальности и Условиями предоставления услуг.</p></div>

            </div>

        </>
    )
}