import { useForm, type SubmitHandler } from "react-hook-form";
import { useRegisterMutation } from "../../../../store/features/auth/authApi";
import type { ApiErrorResponse } from "../../../../types/api";
import useModalById from "../../../../hooks/useModalById";
import InputField from "../../../forms/shared/InputField";
import EmailField from "../../../forms/shared/EmailField";
import PasswordField from "../../../forms/shared/PasswordField";
import SubmitButton from "../../../forms/shared/SubmitButton";
import { useLocation, useNavigate } from "react-router";

interface Inputs {
  name: string;
  email: string;
  password: string;
}

const SignupForm = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const from = location.state?.from?.pathname || "/";

  const {
    register,
    handleSubmit,
    formState: { errors },
    reset,
  } = useForm<Inputs>();

  const [createUser, { isLoading, error, isSuccess }] = useRegisterMutation();
  const { closeModal: closeAuthModal } = useModalById("authModal");

  const onSubmit: SubmitHandler<Inputs> = async (data) => {
    try {
      await createUser(data).unwrap();

      closeAuthModal();
      reset();
      navigate(from, { replace: true });
    } catch (err) {
      console.error("Failed to create user:", err);
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
          <p>User created successfully!</p>
        </div>
      )}

      <form onSubmit={handleSubmit(onSubmit)} className="space-y-4" noValidate>
        <InputField
          id="name"
          label="Name"
          type="text"
          placeholder="Enter your name"
          registerProps={register("name", {
            required: "Name is required",
          })}
          error={errors?.name}
        />
        <EmailField register={register} error={errors?.email} />
        <PasswordField
          register={register}
          error={errors?.password}
          isRegistration={true}
        />

        <SubmitButton
          isLoading={isLoading}
          label="Sign Up"
          loadingLabel="Creating account..."
        />
      </form>
    </>
  );
};

export default SignupForm;
