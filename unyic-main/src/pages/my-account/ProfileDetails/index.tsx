import ProfileDetailsForm from "./ProfileDetailsForm";

const ProfileDetails = () => {
  return (
    <div className="max-w-lg lg:mt-12 mx-auto p-6 sm:p-8 rounded bg-white">
      <div className="mb-6">
        <h1 className="text-2xl font-semibold">Personal Information</h1>
        <p className="mt-1 text-sm text-dark-light">
          Manage your profile details and contact information
        </p>
      </div>

      <ProfileDetailsForm />
    </div>
  );
};

export default ProfileDetails;
