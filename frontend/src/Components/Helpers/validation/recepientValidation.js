import * as yup from 'yup';

export const recepientValidation = yup.object().shape({
    email: yup.string()
        .required('Поле E-mail необходимо заполнить')
        .email('Указан некорректный email'),
    account: yup.string()
        .required('Обязательно для заполнения')
        .min(6, 'Минимальное кол-во символов - 6')
        .max(20,'Максимальное кол-во символов - 20'),
    fs: yup.string(),
});