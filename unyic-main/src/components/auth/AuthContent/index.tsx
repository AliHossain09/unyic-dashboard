import { useState } from "react";
import useModalById from "../../../hooks/useModalById";
import type { AuthActiveTab } from "../../../types/modal";
import TabButtons from "./TabButtons";
import LoginForm from "./forms/LoginForm";
import SignupForm from "./forms/SignupForm";

const AuthContent = () => {
  const { modalData } = useModalById("authModal");
  const [activeTab, setActiveTab] = useState<AuthActiveTab>(
    modalData?.activeTab || "login"
  );

  return (
    <div className="px-8 pt-6 pb-12">
      <TabButtons activeTab={activeTab} setActiveTab={setActiveTab} />

      <div className="mt-8">
        {activeTab === "login" ? <LoginForm /> : <SignupForm />}
      </div>

      {/* <SocialLoginButtons /> */}
    </div>
  );
};

export default AuthContent;
