import * as yup from 'yup';

export const confirmValidation = yup.object().shape({
        code: yup.number()
            .required('Введите 4-значный код для авторизации')
    });