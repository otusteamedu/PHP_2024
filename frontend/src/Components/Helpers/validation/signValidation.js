import * as yup from 'yup';

export const signValidation = yup.object().shape({
        email: yup.string()
            .required('Поле E-mail необходимо заполнить')
            .email('Указан некорректный email'),
        password: yup.string()
            .required('Обязательно для заполнения')
            .min(6, 'Минимальное кол-во символов - 6')
            .max(20,'Максимальное кол-во символов - 20'),
    });