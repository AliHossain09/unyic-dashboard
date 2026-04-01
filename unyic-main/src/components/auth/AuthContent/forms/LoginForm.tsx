import { useForm, type SubmitHandler } from "react-hook-form";
import { MdCheckBox, MdCheckBoxOutlineBlank } from "react-icons/md";
import useModalById from "../../../../hooks/useModalById";
import { useLoginMutation } from "../../../../store/features/auth/authApi";
import type { ApiErrorResponse } from "../../../../types/api";
import AuthEmailField from "./components/AuthEmailField";
import AuthPasswordField from "./components/AuthPasswordField";
import AuthSubmitButton from "./components/AuthSubmitButton";

interface Inputs {
  email: string;
  password: string;
  rememberMe: boolean;
}

const LoginForm = () => {
  const {
    register,
    handleSubmit,
    formState: { errors },
    reset,
  } = useForm<Inputs>();
  const { openModal: openForgotPasswordModal } = useModalById(
    "forgotPasswordModal"
  );
  const { closeModal: closeAuthModal } = useModalById("authModal");

  const [login, { isLoading, error, isSuccess }] = useLoginMutation();

  const handleForgotPasswordClick = () => {
    closeAuthModal();
    openForgotPasswordModal();
  };

  const onSubmit: SubmitHandler<Inputs> = async (data) => {
    try {
      await login(data).unwrap();

      closeAuthModal();
      reset();
    } catch (err) {
      console.error("Failed to logged user:", err);
    }
  };

  return (
    <>
      {error && (
        <div className="h-8 mb-3 bg-red-100 grid place-items-center text-sm text-red-600">
          <p>{(error as ApiErrorResponse)?.errors[0]}</p>
        </div>
      )}

      {isSuccess && (
        <div className="h-8 mb-3 bg-success/10 grid place-items-center text-sm text-success">
          <p>Logged in successfully!</p>
        </div>
      )}

      <form onSubmit={handleSubmit(onSubmit)} className="space-y-4" noValidate>
        <AuthEmailField register={register} error={errors?.email} />

        <div className="relative">
          <AuthPasswordField register={register} error={errors?.password} />

          <div className="text-end">
            <button
              type="button"
              className="text-sm mt-1 text-primary underline underline-offset-1"
              onClick={handleForgotPasswordClick}
            >
              Forgot Password?
            </button>
          </div>
        </div>

        <label htmlFor="rememberMe" className="w-max flex gap-2 items-center">
          <input
            type="checkbox"
            id="rememberMe"
            className="hidden peer"
            {...register("rememberMe")}
          />

          <MdCheckBox className="text-primary text-xl hidden peer-checked:block" />
          <MdCheckBoxOutlineBlank className="text-primary-light text-xl peer-checked:hidden" />

          <span>Remember me</span>
        </label>

        <AuthSubmitButton isLoading={isLoading} label="Login" />
      </form>
    </>
  );
};

export default LoginForm;
