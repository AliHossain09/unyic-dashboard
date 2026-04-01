import { useForm, type SubmitHandler } from "react-hook-form";
import { useRegisterMutation } from "../../../../store/features/auth/authApi";
import type { ApiErrorResponse } from "../../../../types/api";
import AuthInputField from "./components/AuthInputField";
import AuthEmailField from "./components/AuthEmailField";
import AuthPasswordField from "./components/AuthPasswordField";
import AuthSubmitButton from "./components/AuthSubmitButton";
import useModalById from "../../../../hooks/useModalById";

interface Inputs {
  name: string;
  email: string;
  password: string;
}

const SignupForm = () => {
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
        <AuthInputField
          id="name"
          label="Name"
          type="text"
          placeholder="Enter your name"
          registerProps={register("name", {
            required: "Name is required",
          })}
          error={errors?.name}
        />
        <AuthEmailField register={register} error={errors?.email} />
        <AuthPasswordField register={register} error={errors?.password} />

        <AuthSubmitButton isLoading={isLoading} label="Sign Up" />
      </form>
    </>
  );
};

export default SignupForm;
