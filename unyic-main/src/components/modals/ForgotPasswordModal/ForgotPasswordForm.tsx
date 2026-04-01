import { useForm, type SubmitHandler } from "react-hook-form";
import Button from "../../ui/Button";
import AuthEmailField from "../../auth/AuthContent/forms/components/AuthEmailField";

interface Inputs {
  email: string;
}

const ForgotPasswordForm = () => {
  const {
    register,
    handleSubmit,
    formState: { errors, isValid },
  } = useForm<Inputs>({
    mode: "onTouched",
  });

  const onSubmit: SubmitHandler<Inputs> = (data) => {
    console.log("Password recovery email sent to:", data.email);
    alert(
      "If this email is registered, you will receive a password reset link."
    );
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4" noValidate>
      <AuthEmailField register={register} error={errors?.email} />

      <Button type="submit" disabled={!isValid}>
        Send Reset Link
      </Button>
    </form>
  );
};

export default ForgotPasswordForm;
