import BlogHeader from "./components/BlogHeader";
import BlogContent from "./components/BlogContent";
import AboutBrand from "./components/AboutBrand";
import RecentArticles from "./components/RecentArticles";

const Blog = () => {
  return (
    <>
      <BlogHeader />

      <div className="ui-container mt-6! grid grid-cols-1 md:grid-cols-4 gap-16">
        <div className="md:col-span-3">
          <BlogContent />
        </div>
        <div className="space-y-12">
          <AboutBrand />
          <RecentArticles />
        </div>
      </div>
    </>
  );
};

export default Blog;
