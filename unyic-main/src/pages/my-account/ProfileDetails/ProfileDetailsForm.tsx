import { useForm } from "react-hook-form";
import useUser from "../../../hooks/useUser";
import InputField from "../../../components/forms/shared/InputField";
import PhoneField from "../../../components/forms/shared/PhoneField";
import SubmitButton from "../../../components/forms/shared/SubmitButton";
import { useUpdateUserMutation } from "../../../store/features/user/userApi";
import toast from "react-hot-toast";

interface Inputs {
  name: string;
  phone: string;
}

const ProfileDetailsForm = () => {
  const { user } = useUser();
  const [updateUser, { isLoading }] = useUpdateUserMutation();

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<Inputs>({
    defaultValues: {
      name: user?.name,
      phone: user?.phone,
    },
  });

  const onSubmit = async (data: Inputs) => {
    try {
      await updateUser({
        name: data.name,
        phone: data.phone,
      }).unwrap();

      toast.success("Updated successfully!");
    } catch (error) {
      toast.error("Failded to update");
      console.error("Failed to update profile details :", error);
    }
  };

  return (
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

      <PhoneField register={register} error={errors?.phone} />

      <SubmitButton
        isLoading={isLoading}
        label="Save Changes"
        loadingLabel="Saving..."
        className="block max-w-40 ms-auto"
      />
    </form>
  );
};

export default ProfileDetailsForm;
