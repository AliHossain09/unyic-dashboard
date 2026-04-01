import { MdCheckBox, MdCheckBoxOutlineBlank } from "react-icons/md";
import InputField from "./InputField";
import { useForm } from "react-hook-form";

export interface DeliveryInfoFormData {
  name: string;
  email: string;
  phone: string;
  city: string;
  country: string;
  address: string;
  saveInfo: boolean;
}

interface DeliveryInfoFormProps {
  onSubmit: (data: DeliveryInfoFormData) => void;
}

const DeliveryInfoForm = ({ onSubmit }: DeliveryInfoFormProps) => {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<DeliveryInfoFormData>({ mode: "onTouched" });

  return (
    <div className="lg:col-span-2 bg-light-dark py-3 md:p-6">
      <div className="p-4 md:p-8 md:pt-6 bg-light">
        <h3 className="text-lg font-semibold mb-4">Delivery Information</h3>

        <form
          id="delivery-info-form"
          onSubmit={handleSubmit(onSubmit)}
          className="space-y-4"
        >
          {/* Name */}
          <InputField
            id="name"
            label="Full Name"
            placeholder="Enter your full name"
            error={errors?.name}
            registerProps={register("name", {
              required: "Full name is required",
            })}
          />

          {/*Email and Phone and Address */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <InputField
              id="email"
              label="Email"
              type="email"
              placeholder="Enter your email"
              error={errors?.email}
              registerProps={register("email", {
                required: "Email is required",
                pattern: {
                  value: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                  message: "Please enter a valid email address",
                },
              })}
            />
            <InputField
              id="phone"
              type="tel"
              label="Phone Number"
              placeholder="Enter your phone number"
              error={errors?.phone}
              registerProps={register("phone", {
                required: "Phone number is required",
                pattern: {
                  value: /^[0-9]{10,15}$/,
                  message: "Please enter a valid phone number",
                },
              })}
            />
          </div>

          {/* City and Country */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <InputField
              id="city"
              label="City"
              placeholder="Enter your city"
              error={errors?.city}
              registerProps={register("city", {
                required: "City is required",
              })}
            />
            <InputField
              id="country"
              label="Country"
              placeholder="Enter your country"
              error={errors?.country}
              registerProps={register("country", {
                required: "Country is required",
              })}
            />
          </div>

          {/* Address */}
          <InputField
            id="address"
            label="Address"
            placeholder="Enter your address"
            error={errors?.address}
            registerProps={register("address", {
              required: "Address is required",
            })}
          />

          {/* Save Information Checkbox */}
          <label htmlFor="saveInfo" className="w-max flex gap-2 items-center">
            <input
              type="checkbox"
              id="saveInfo"
              className="hidden peer"
              {...register("saveInfo")}
            />
            <MdCheckBox className="text-primary text-xl hidden peer-checked:block" />
            <MdCheckBoxOutlineBlank className="text-primary-light text-xl peer-checked:hidden" />
            <span>Save this information for next time</span>
          </label>
        </form>
      </div>
    </div>
  );
};

export default DeliveryInfoForm;
